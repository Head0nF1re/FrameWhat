<?php

namespace Core\Routing;

class Router
{
    public string $controller;

    public string $controllerMethod;

    private array $routes;

    public function match(string $method, string $uri)
    {
        $this->controller = $this->routes[$method][$uri][0];
        $this->controllerMethod = $this->routes[$method][$uri][1];
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
