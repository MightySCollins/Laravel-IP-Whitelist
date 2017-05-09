<?php

namespace AtomJuice\IpWhitelist;

use Illuminate\Support\ServiceProvider;

class IpWhitelistServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }
}
