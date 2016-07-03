<?php

namespace User\Api;

use ZendBricks\BricksUser\Api\UserApiInterface;
use Interop\Container\ContainerInterface;

class UserApi implements UserApiInterface
{
    protected $pdo;
    protected $container;

    public function __construct(\PDO $pdo, ContainerInterface $container)
    {
        $this->pdo = $pdo;
        $this->container = $container;
    }
    
    public function setSessionIdentity($sessionId, $identity)
    {
        if ($this->pdo->query("SELECT id FROM `session` WHERE identity = '$identity'")->fetch()) {
            $this->pdo->query("UPDATE `session` SET id = '$sessionId' WHERE identity = '$identity'");
        } else {
            $this->pdo->query("INSERT INTO `session` VALUES ('$sessionId', '$identity')");
        }
    }
    
    public function getSessionIdentity($sessionId)
    {
        $result = $this->pdo->query("SELECT identity FROM `session` WHERE id = '$sessionId'");
        if ($result = $result->fetch()) {
            return $result['identity'];
        } else {
            return false;
        }
    }
    
    public function clearSessionIdentity($sessionId)
    {
        $this->pdo->query("DELETE FROM `session` WHERE id = '$sessionId'");
    }

    public function getIdByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE username = :username");
        $stmt->bindParam('username', $username);
        $stmt->execute();
        if ($result = $stmt->fetch()) {
            return $result['id'];
        } else {
            return false;
        }
    }
    
    public function getIdByEmail($email)
    {
        $result = $this->pdo->query("SELECT id FROM user WHERE email = '$email'");
        if ($result = $result->fetch()) {
            return $result['id'];
        } else {
            return false;
        }
    }
    
    public function getUsernameById($userId)
    {
        $result = $this->pdo->query("SELECT username FROM user WHERE id = '$userId'");
        if ($result = $result->fetch()) {
            return $result['username'];
        } else {
            return false;
        }
    }

    public function getPasswordById($userId)
    {
        $result = $this->pdo->query("SELECT password FROM user WHERE id = '$userId'");
        if ($result = $result->fetch()) {
            return $result['password'];
        } else {
            return false;
        }
    }
    
    public function isUserActivated($userId)
    {
        $result = $this->pdo->query("SELECT role_id FROM user WHERE id = '$userId'");
        $result = $result->fetch();
        if ($result && $result['role_id'] != 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public function activateUser($userId)
    {
        $this->pdo->query("UPDATE user SET role_id = (SELECT id FROM role WHERE name = 'User') WHERE id = $userId");
    }

    public function getRoleNameByIdentity($userId)
    {
        /* @var $userRoleCache \Zend\Cache\Storage\Adapter\AbstractAdapter */
        $userRoleCache = $this->container->get('UserRoleCache');
        $role = $userRoleCache->getItem($userId);
        if (!$role) {
            $result = $this->pdo->query("SELECT r.name FROM user u INNER JOIN role r ON r.id = u.role_id WHERE u.id = '$userId'");
            if ($result = $result->fetch()) {
                $role = $result['name'];
                $userRoleCache->setItem($userId, $role);
            } else {
                return false;
            }
        }
        return $role;
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
        $roles = $this->pdo->query("SELECT id,name,parent_role_id FROM role")->fetchAll();
        $rolesById = [];
        foreach ($roles as $role) {
            $rolesById[$role['id']] = $role['name'];
        }
        $result = [];
        foreach ($roles as $role) {
            $parentRoles = [];
            $parentRoleId = $role['parent_role_id'];
            if ($parentRoleId) {
                $parentRoles[] = $rolesById[$role['parent_role_id']];
            }
            $result[$role['name']] = $parentRoles;
        }
        return $result;
    }

    public function getRolePermissions()
    {
        $query = $this->pdo->query("SELECT r.name as role_name,p.name as permission_name FROM role_permission rp INNER JOIN role r ON rp.role_id = r.id INNER JOIN permission p ON rp.permission_id = p.id");
        $result = [];
        while ($rolePermission = $query->fetch()) {
            if (!array_key_exists($rolePermission['role_name'], $result)) {
                $result[$rolePermission['role_name']] = [];
            }
            $result[$rolePermission['role_name']][] = $rolePermission['permission_name'];
        }
        return $result;
    }
    
    public function getDeniedRolePermissions()
    {
        return [
            'User' => [
                'auth/login',
                'auth/register'
            ]
        ];
    }

    public function registerUser($username, $mail, $password)
    {
        $this->pdo->query("INSERT INTO user (username, email, password, role_id) VALUES('$username', '$mail', '$password', 1)");
        return $this->pdo->lastInsertId();
    }
    
    public function createRegisterToken($userId, $token)
    {
        $this->pdo->query("DELETE FROM register_token WHERE user_id = '$userId'");
        $this->pdo->query("INSERT INTO register_token (user_id, token) VALUES('$userId', '$token')");
    }

    public function getUserIdByRegisterToken($token)
    {
        $result = $this->pdo->query("SELECT user_id FROM register_token WHERE token = '$token'");
        if ($result = $result->fetch()) {
            return $result['user_id'];
        } else {
            return false;
        }
    }
    
    public function deleteRegisterToken($userId)
    {
        $this->pdo->query("DELETE FROM register_token WHERE user_id = '$userId'");
    }
    
    public function createPasswordToken($userId, $token)
    {
        $this->pdo->query("DELETE FROM password_token WHERE user_id = '$userId'");
        $this->pdo->query("INSERT INTO password_token (user_id, token) VALUES('$userId', '$token')");
    }

    public function getUserIdByPasswordToken($token)
    {
        $result = $this->pdo->query("SELECT user_id FROM password_token WHERE token = '$token'");
        if ($result = $result->fetch()) {
            return $result['user_id'];
        } else {
            return false;
        }
    }
    
    public function deletePasswordToken($userId)
    {
        $this->pdo->query("DELETE FROM password_token WHERE user_id = '$userId'");
    }
    
    public function setPassword($userId, $password)
    {
        $this->pdo->query("UPDATE user SET password = '$password' WHERE id = '$userId'");
    }
    
    public function onRoleChanged($userId)
    {
        /* @var $userRoleCache \Zend\Cache\Storage\Adapter\AbstractAdapter */
        $userRoleCache = $this->container->get('UserRoleCache');
        $userRoleCache->removeItem($userId);
    }
}
