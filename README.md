# IP Whitelist

This package is designed to work with the [mpociot/teamwork](https://github.com/mpociot/teamwork) package for Laravel 5..

### Installation
You can install this package with composer:

    composere require atomjuice\ipwhitelist

Add the middleware below to your `$routeMiddleware` in `App\Http\Kernel.php`.
```php
protected $routeMiddleware = [
    ...
    'ip' => \AtomJuice\IpWhitelist\Http\Middleware\IpWhitelist::class,
];
```

You can then add it to app API requests like below
```php
'api' => [
    ...
    'ip'
],
```