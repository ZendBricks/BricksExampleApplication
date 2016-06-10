<?php

namespace User\Auth;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Session\SessionManager;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\AuthenticationService;
use Zend\Crypt\Password\Bcrypt;

class AuthServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $sessionManager \Zend\Session\SessionManager */
        $sessionManager = $container->get(SessionManager::class);
        
        /* @var $userApi \User\Api\UserApi */
        $userApi = $container->get('UserApi');
        
        $storage = new ApiSessionStorage($userApi);
        
        /* @var $adapter \User\Auth\AuthServiceFactory */
        $adapter = new ApiAuthAdapter($userApi);
        
        return new AuthenticationService($storage, $adapter);
    }
}
