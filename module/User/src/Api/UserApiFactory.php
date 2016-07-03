<?php

namespace User\Api;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use User\Api\UserApi;

class UserApiFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $pdo = $container->get('pdo');
        return new UserApi($pdo, $container);
    }   
}
