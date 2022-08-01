<?php

namespace Core;

use App\Http\Controllers\TestController;
use Core\Container\Container;
use Psr\Container\ContainerInterface;

class App extends Container
{
    public function run()
    {
        // Testing manual binding
        $this->set(
            ContainerInterface::class,
            fn($c) => $c->resolve(TestController::class)
        );

        dd($this->get(ContainerInterface::class));
        /*
         *  Testing
         */
        $uri = str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);

        dump($_SERVER);

        $router = require base_path('routes/web.php');
        $router->match($_SERVER['REQUEST_METHOD'], $uri);

        $this->resolve($router->controller)->{$router->controllerMethod}();
    }

}
