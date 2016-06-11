<?php

namespace User\Auth;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Permissions\Acl\Acl;

class AclFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $aclCache \Zend\Cache\Storage\StorageInterface */
        $aclCache = $container->get('AclCache');
        $acl = $aclCache->getItem('Acl');
        if (!$acl) {
            /* @var $userApi \User\Api\UserApi */
            $userApi = $container->get('UserApi');

            $acl = new Acl();

            $resources = $userApi->getPermissions();
            foreach ($resources as $resource) {
                $acl->addResource($resource);
            }

            $roles = $userApi->getRoles();
            foreach ($roles as $role => $parents) {
                $acl->addRole($role, $parents);
            }

            $rolePermissions = $userApi->getRolePermissions();
            foreach ($rolePermissions as $role => $permissions) {
                $acl->allow($role, $permissions);
            }
            
            $aclCache->setItem('Acl', $acl);
        }
        
        return $acl;
    }
}
