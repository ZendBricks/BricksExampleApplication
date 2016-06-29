<?php

namespace User\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use User\Controller\AuthController;
use Zend\Authentication\AuthenticationService;

class AuthControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $api = $container->get('UserApi');
        $authService = $container->get(AuthenticationService::class);
        $mailModel = $container->get('UserMailModel');
        $config = $container->get('config');
        $projectName = $config['project.name'];
        $userRoleCache = $container->get('UserRoleCache');
        return new AuthController($api, $authService, $mailModel, $projectName, $userRoleCache);
    }   
}
