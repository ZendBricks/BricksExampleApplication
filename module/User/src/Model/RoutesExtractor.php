<?php

namespace User\Model;

class RoutesExtractor
{
    protected $router;
    protected $routes;

    public function __construct(array $router)
    {
        $this->router = $router;
    }
    
    public function getRoutes()
    {
        $routes = [];
        if (array_key_exists('routes', $this->router)) {
            $routes = $this->router['routes'];
        }
        $this->addRoutes($routes);
        return $this->routes;
    }
    
    protected function addRoutes(array $routes, $prefix = null)
    {
        foreach ($routes as $name => $route) {
            $routeName = $prefix . $name;
            $mayTerminate = true;
            if (array_key_exists('child_routes', $route)) {
                $this->addRoutes($route['child_routes'], $routeName . '/');
                $mayTerminate = false;
            }
            if (array_key_exists('may_terminate', $route)) {
                $mayTerminate = $route['may_terminate'];
            }
            if ($mayTerminate) {
                $this->routes[] = $routeName;
            }
        }
    }
}
