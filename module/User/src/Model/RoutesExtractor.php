<?php

namespace User\Model;

use Zend\Router\Http\TreeRouteStack;
use Zend\Router\Http\Part;

class RoutesExtractor
{
    protected $router;
    protected $routes;

    public function __construct(TreeRouteStack $router)
    {
        $this->router = $router;
    }
    
    public function getRoutes()
    {
        $routes = $this->router->getRoutes()->toArray();
        $this->addRoutes($routes);
        return $this->routes;
    }
    
    protected function addRoutes(array $routes, $prefix = null)
    {
        foreach ($routes as $name => $route) {
            if ($route instanceof Part) {
                $this->addRoutes($route->getRoutes()->toArray(), $prefix . $name . '/');
            } else {
                $routeName = $prefix . $name;
                $this->routes[] = $routeName;
            }
        }
    }
}
