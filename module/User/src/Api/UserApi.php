<?php

namespace User\Api;

class UserApi implements UserApiInterface
{
    protected $pdo;
    
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
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
        $result = $this->pdo->query("SELECT password FROM user WHERE username = '$username'")->fetch();
        if (is_array($result)) {
            return reset($result);
        } else {
            return $result;
        }
    }

    public function getRoleNameByIdentity($userId)
    {
        $result = $this->pdo->query("SELECT r.name FROM user u INNER JOIN role r ON r.id = u.role_id WHERE u.id = '$userId'")->fetch();
        if (is_array($result)) {
            return reset($result);
        } else {
            return $result;
        }
    }
    
    public function addPermission($name)
    {
        $this->pdo->query("INSERT INTO permission(name) VALUES('$name')");
    }

    public function getPermissions()
    {
        $query = $this->pdo->query("SELECT name FROM permission");
        $result = [];
        while ($permission = $query->fetch()) {
            $result[] = reset($permission);
        }
        return $result;
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
//            'Guest' => [
//                'auth/login',
//                'auth/register'
//            ],
//            'User' => [
//                'auth/logout'
//            ]
        ];
    }
}
