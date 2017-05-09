<?php

namespace App\Models\Auth;

use App\Models\Model;
use Mpociot\Teamwork\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\SoftDeletes;
use AtomJuice\IpWhitelist\Exceptions\NoUserInTeamException;

class WhitelistedIp extends Model
{
    use SoftDeletes, UsedByTeams;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'team_id', 'address'
    ];

    /**
     * @throws NoUserInTeamException
     */
    protected static function teamGuard()
    {
        if (auth()->guest() || !auth()->user()->currentTeam) {
            throw new NoUserInTeamException('No authenticated user with selected team present.');
        }
    }
}
