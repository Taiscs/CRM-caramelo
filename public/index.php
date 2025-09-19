<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php'; // <-- '../' sobe da pasta public para a raiz
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
