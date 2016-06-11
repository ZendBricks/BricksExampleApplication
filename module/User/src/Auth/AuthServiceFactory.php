<?php

namespace User\Auth;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

class AuthServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $userApi \User\Api\UserApi */
        $userApi = $container->get('UserApi');
        
        $storage = new ApiSessionStorage($userApi);
        
        $adapter = new ApiAuthAdapter($userApi);
        
        return new AuthenticationService($storage, $adapter);
    }
}
