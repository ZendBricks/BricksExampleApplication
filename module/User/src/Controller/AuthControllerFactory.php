<?php

namespace User\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\View\Renderer\RendererInterface;
use User\Controller\AuthController;

class AuthControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $api = $container->get('UserApi');
        $authService = $container->get('Auth');
        $renderer = $container->get(RendererInterface::class);
        return new AuthController($api, $authService, $renderer);
    }   
}
