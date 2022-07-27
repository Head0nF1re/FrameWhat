<?php

use App\Http\Controllers\TestController;
use Core\Routing\Router as Route;

return (new Route())
    ->get('/', [TestController::class, 'testOne'])
    ->get('/test', [TestController::class, 'testTwo'])
    ->post('/hmm', [TestController::class, 'another']);
