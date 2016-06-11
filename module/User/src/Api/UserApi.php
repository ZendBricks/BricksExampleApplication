<?php

namespace User\Api;

class UserApi implements UserApiInterface
{
    protected $pdo;
    
    public function __construct(\PDO $pdo)
    {
        $this->pdo;
    }
    
    public function setSessionIdentity($sessionId, $identity)
    {
        
    }
    
    public function getSessionIdentity($sessionId)
    {
        
    }
    
    public function clearSessionIdentity($sessionId)
    {
        
    }

    public function getPasswordByUsername($username)
    {
        
    }

    public function getRoleNameByIdentity($userId)
    {
        
    }
    
    public function addPermission($name)
    {
        
    }

    public function getPermissions()
    {
        return [
            'auth/login',
            'auth/register',
            'auth/logout'
        ];
    }
    
    public function getRoles()
    {
        return [
            'Guest' => [],
            'User' => ['Guest']
        ];
    }

    public function getRolePermissions()
    {
        return [
            'Guest' => [
                'auth/login',
                'auth/register'
            ],
            'User' => [
                'auth/logout'
            ]
        ];
    }
}
