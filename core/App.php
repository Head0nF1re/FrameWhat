<?php

namespace Core;

use Core\Container\Container;

class App extends Container
{
    public function run()
    {
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
