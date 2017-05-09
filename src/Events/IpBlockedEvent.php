<?php

namespace AtomJuice\IpWhitelist\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class IpBlockedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $ip;
    protected $user;

    public function __construct(int $ip, $user)
    {
        $this->ip = $ip;
        $this->user = $user;
    }
}
