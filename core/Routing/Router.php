<?php

namespace Core\Routing;

class Router
{
    private array $routes;

    public function resolve(string $method, string $uri)
    {
        $controller = new $this->routes[$method][$uri][0]();
        $controller->{$this->routes[$method][$uri][1]}();
    }

    public function __call($name, $arguments)
    {
        /*
         * $arguments[0] - uri
         * $arguments[1] - [controller, method]
         */
        $this->routes[strtoupper($name)][$arguments[0]] = $arguments[1];

        return $this;
    }

}
