<?php

namespace AtomJuice\IpWhitelist\Http\Middleware;

use Log;
use Cache;
use Closure;
use Illuminate\Http\Request;
use App\Models\Auth\WhitelistedIp;
use Symfony\Component\HttpFoundation\IpUtils;
use AtomJuice\IpWhitelist\Events\IpBlockedEvent;
use AtomJuice\IpWhitelist\Exceptions\NoUserInTeamException;

class IpWhitelist
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!isset($user)) {
            return $next($request);
        }
        // 43800 is one month
        $ipAddresses = Cache::remember('user_ip_'.$user->id, 43800, function () {
            try {
                return WhitelistedIp::all();
            } catch (NoUserInTeamException $exception) {
                return [];
            }
        });

        if (count($ipAddresses) < 1) {
            return $next($request);
        }

        if (IpUtils::checkIp($request->ip(), $ipAddresses->pluck('address')->toArray())) {
            return $next($request);
        };
        $this->logBlocked($request->ip(), $user, $user->currentTeam);
        event(new IpBlockedEvent($request->ip(), $user));
        return response('IP not whitelisted', 403);
    }

    private function logBlocked($ip, $user, $team)
    {
        Log::info("IP $ip blocked for user $user->name $user->id team $team->name $team->id");
    }
}
