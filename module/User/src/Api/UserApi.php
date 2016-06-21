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
        $result = $this->pdo->query("SELECT id FROM user WHERE username = '$username'");
        if ($result = $result->fetch()) {
            return $result['id'];
        } else {
            return false;
        }
    }

    public function getPasswordById($id)
    {
        $result = $this->pdo->query("SELECT password FROM user WHERE id = '$id'");
        if ($result = $result->fetch()) {
            return $result['password'];
        } else {
            return false;
        }
    }

    public function getRoleNameByIdentity($userId)
    {
        $result = $this->pdo->query("SELECT r.name FROM user u INNER JOIN role r ON r.id = u.role_id WHERE u.id = '$userId'");
        if ($result = $result->fetch()) {
            return $result['name'];
        } else {
            return false;
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
}
