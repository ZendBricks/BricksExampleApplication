<?php

namespace User\Controller;

use Zend\Mvc\Console\Controller\AbstractConsoleController;
use Interop\Container\ContainerInterface;
use Zend\Router\Http\TreeRouteStack;
use User\Model\RoutesExtractor;

class ConsoleController extends AbstractConsoleController
{
    protected $container;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function addPermissionsAction()
    {
        /* @var $userApi \User\Api\UserApi */
        $userApi = $this->container->get('UserApi');
        $existingPermissions = $userApi->getPermissions();
        
        $config = $this->container->get('Config');
        $router = TreeRouteStack::factory($config['router']);
        $routesExtractor = new RoutesExtractor($router);
        $routes = $routesExtractor->getRoutes();
        
        foreach ($routes as $route) {
            if (!in_array($route, $existingPermissions, true)) {
                $userApi->addPermission($route);
                echo "added route: $route\n";
            }
        }
    }
}
