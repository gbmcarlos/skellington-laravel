<?php

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

$app = new Laravel\Lumen\Application(dirname(__DIR__));

$app->withFacades();

$app->withEloquent();

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Toolkit\Helpers\ExceptionHandlers\ApiExceptionHandler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Laravel\Lumen\Console\Kernel::class
);

$app->configure('app');
$app->configure('config');
$app->configure('cache');

// register service providers from config/app.php
foreach (\Illuminate\Support\Facades\Config::get('app.providers') as $provider) {
    $app->register($provider);
}

$timezone = \Illuminate\Support\Facades\Config::get('app.timezone');

if (in_array($timezone, timezone_identifiers_list())) {
    date_default_timezone_set(\Illuminate\Support\Facades\Config::get('app.timezone'));
}

return $app;
