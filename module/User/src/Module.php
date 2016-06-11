<?php

namespace User;

use Zend\Mvc\MvcEvent;
use Zend\Console\Request;
use Interop\Container\ContainerInterface;

class Module
{
    const VERSION = '1.0.0';

    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        
        if ($e->getRequest() instanceof Request) {  //exclude console-application
            return true;
        }
        
        $eventManager->attach(MvcEvent::EVENT_ROUTE, [$this, 'checkAuth']);
        
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, function(MvcEvent $e) {   //fix that navigation renders without acl
            $e->getApplication()->getServiceManager()->get('Acl');
        });
    }
    
    public function checkAuth(MvcEvent $e)
    {
        /* @var $container ContainerInterface */
        $container = $e->getApplication()->getServiceManager();
        /* @var $acl \Zend\Permissions\Acl\AclInterface */
        $acl = $container->get('Acl');
        $role = $this->getRole($container);
        if (!$acl->isAllowed($role, $e->getRouteMatch()->getMatchedRouteName())) {
            $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, function(MvcEvent $e) {
                $response = $e->getResponse();
                $response->setStatusCode(302);
                $e->stopPropagation();
            }, 2);
        }
        
//        $container->get('viewhelpermanager')->get('navigation')->setRole($role);
    }
    
    protected function getRole(ContainerInterface $container)
    {
        /* @var $auth \Zend\Authentication\AuthenticationServiceInterface */
        $auth = $container->get('Auth');
        
        if ($auth->getIdentity()) {
            /* @var $userRoleCache \Zend\Cache\Storage\StorageInterface */
            $userRoleCache = $container->get('UserRoleCache');
            $role = $userRoleCache->getItem($auth->getIdentity());
            if (!$role) {
                /* @var $userApi \User\Api\UserApiInterface */
                $userApi = $container->get('UserApi');
                $role = $userApi->getRoleNameByIdentity($auth->getIdentity());
                if ($role) {
                    $userRoleCache->setItem($auth->getIdentity(), $role);
                } else {
                    $role = 'Guest';
                }
            }
        } else {
            $role = 'Guest';
        }

        return $role;
    }
}
