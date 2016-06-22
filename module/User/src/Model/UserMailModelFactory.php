<?php

namespace User\Model;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\View\Renderer\RendererInterface;

class UserMailModelFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $renderer = $container->get(RendererInterface::class);
        return new UserMailModel($config, $renderer);
    }
}
