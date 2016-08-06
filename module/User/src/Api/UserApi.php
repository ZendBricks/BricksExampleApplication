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
        $stmt = $this->pdo->prepare('SELECT id FROM `session` WHERE identity = :identity');
        $stmt->bindParam('identity', $identity);
        $stmt->execute();
        if ($stmt->fetch()) {
            $stmt = $this->pdo->prepare('UPDATE `session` SET id = :sessionId WHERE identity = :identity');
        } else {
            $stmt = $this->pdo->prepare('INSERT INTO `session` VALUES (:sessionId, :identity)');
        }
        $stmt->bindParam('sessionId', $sessionId);
        $stmt->bindParam('identity', $identity);
        $stmt->execute();
    }
    
    public function getSessionIdentity($sessionId)
    {
        $stmt = $this->pdo->prepare('SELECT identity FROM `session` WHERE id = :sessionId');
        $stmt->bindParam('sessionId', $sessionId);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result['identity'];
        } else {
            return false;
        }
    }
    
    public function clearSessionIdentity($sessionId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM `session` WHERE id = :sessionId');
        $stmt->bindParam('sessionId', $sessionId);
        $stmt->execute();
    }

    public function getUserIdByUsername($username)
    {
        $stmt = $this->pdo->prepare('SELECT id FROM user WHERE username = :username');
        $stmt->bindParam('username', $username);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result['id'];
        } else {
            return false;
        }
    }
    
    public function getUsernameByUserId($userId)
    {
        $stmt = $this->pdo->prepare('SELECT username FROM user WHERE id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result['username'];
        } else {
            return false;
        }
    }
    
    public function getUserIdByEmail($email)
    {
        $stmt = $this->pdo->prepare('SELECT id FROM user WHERE email = :email');
        $stmt->bindParam('email', $email);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result['id'];
        } else {
            return false;
        }
    }
    
    public function getEmailByUserId($userId)
    {
        $stmt = $this->pdo->prepare('SELECT email FROM user WHERE id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result['email'];
        } else {
            return false;
        }
    }

    public function getPasswordByUserId($userId)
    {
        $stmt = $this->pdo->prepare('SELECT password FROM user WHERE id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result['password'];
        } else {
            return false;
        }
    }
    
    public function isUserActivated($userId)
    {
        $stmt = $this->pdo->prepare('SELECT role_id FROM user WHERE id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result && $result['role_id'] != 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public function activateUser($userId)
    {
        $stmt = $this->pdo->prepare("UPDATE user SET role_id = (SELECT id FROM role WHERE name = 'User') WHERE id = :userId");
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }
    
    public function countUsers()
    {
        $stmt = $this->pdo->prepare('SELECT count(id) FROM user');
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
    
    public function getUsers($offset, $itemCountPerPage)
    {
        $stmt = $this->pdo->prepare('SELECT u.id,u.username,u.email,r.name as role FROM user u JOIN role r ON u.role_id = r.id LIMIT :offset,:itemCountPerPage');
        $stmt->bindParam('offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam('itemCountPerPage', $itemCountPerPage, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function saveUser($data, $id = null)
    {
        $username = $data['username'];
        $email = $data['email'];
        $role = $data['role'];
        if ($id) {
            $stmt = $this->pdo->prepare('UPDATE user SET username = :username, email = :email, role_id = :roleId WHERE id = :id');
            $stmt->bindParam('username', $username);
            $stmt->bindParam('email', $email);
            $stmt->bindParam('roleId', $role);
            $stmt->bindParam('id', $id);
            return $stmt->execute();
        }
    }
    
    public function getUserData($id)
    {
        $stmt = $this->pdo->prepare('SELECT username,email,role_id FROM user WHERE id = :id');
        $stmt->bindParam('id', $id);
        if ($stmt->execute()) {
            $user = $stmt->fetch();
            return [
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role_id']
            ];
        }
    }
    
    public function deleteUser($userId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM user WHERE id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }

    public function getRoleNameByIdentity($userId)
    {
        /* @var $userRoleCache \Zend\Cache\Storage\Adapter\AbstractAdapter */
        $userRoleCache = $this->container->get('UserRoleCache');
        $role = $userRoleCache->getItem($userId);
        if (!$role) {
            $stmt = $this->pdo->prepare('SELECT r.name FROM user u INNER JOIN role r ON r.id = u.role_id WHERE u.id = :userId');
            $stmt->bindParam('userId', $userId);
            $stmt->execute();
            $result = $stmt->fetch();
            if ($result) {
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
        $stmt = $this->pdo->prepare('INSERT INTO permission(name) VALUES(:name)');
        $stmt->bindParam('name', $name);
        $stmt->execute();
    }

    public function getPermissions()
    {
        $stmt = $this->pdo->prepare('SELECT id,name FROM permission');
        $stmt->execute();
        $result = [];
        while ($permission = $stmt->fetch()) {
            $result[$permission['id']] = $permission['name'];
        }
        return $result;
    }
    
    public function saveRole($data, $id = null)
    {
        $name = $data['name'];
        $parent = $data['parent'];
        if ($id) {
            $stmt = $this->pdo->prepare('UPDATE role SET name = :name WHERE id = :id');
            $stmt->bindParam('id', $id);
            $stmt->bindParam('name', $name);
            if ($stmt->execute()) {
                $stmt = $this->pdo->prepare('DELETE FROM role_parent_role WHERE role_id = :id');
                $stmt->bindParam('id', $id);
                if ($stmt->execute()) {
                    $stmt = $this->pdo->prepare('INSERT INTO role_parent_role VALUES (:roleId, :parentRoleId)');
                    $stmt->bindParam('roleId', $id);
                    foreach ($parent as $parentRoleId) {
                        $stmt->bindParam('parentRoleId', $parentRoleId);
                        if (!$stmt->execute()) {
                            return false;
                        }
                    }
                    return true;
                }
            }
        } else {
            $stmt = $this->pdo->prepare('INSERT INTO role(name) VALUES(:name)');
            $stmt->bindParam('name', $name);
            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();
            }
        }
    }
    
    public function getRoleName($roleId)
    {
        $stmt = $this->pdo->prepare('SELECT name FROM role WHERE id = :id');
        $stmt->bindParam('id', $roleId);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result['name'];
        } else {
            return false;
        }
    }

    public function getRoleData($id)
    {
        $stmt = $this->pdo->prepare('SELECT name FROM role WHERE id = :id');
        $stmt->bindParam('id', $id);
        if ($stmt->execute()) {
            $role = $stmt->fetch();
            $role['parent'] = [];
            $stmt = $this->pdo->prepare('SELECT parent_role_id FROM role_parent_role WHERE role_id = :id');
            $stmt->bindParam('id', $id);
            if ($stmt->execute()) {
                while ($parent = $stmt->fetch()) {
                    $role['parent'][] = $parent['parent_role_id'];
                }
                return $role;
            }
        }
    }
    
    public function deleteRole($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM role WHERE id = :id');
        $stmt->bindParam('id', $id);
        return $stmt->execute();
    }
    
    public function countRoles()
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(id) FROM role');
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
    
    public function getRoles($offset, $itemCountPerPage)
    {
        $stmt = $this->pdo->prepare('SELECT r.id,r.name,p.name as parent_role FROM role r LEFT JOIN role_parent_role rx ON r.id = rx.role_id LEFT JOIN role p ON rx.parent_role_id = p.id ORDER BY r.id ASC LIMIT :offset,:itemCountPerPage');
        $stmt->bindParam('offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam('itemCountPerPage', $itemCountPerPage, \PDO::PARAM_INT);
        $stmt->execute();
        $roles = $stmt->fetchAll();
        $rolesById = [];
        foreach ($roles as $role) {
            if (!array_key_exists($role['id'], $rolesById)) {
                $rolesById[$role['id']] = [];
            }
            $rolesById[$role['id']][] = $role;
        }
        $result = [];
        foreach ($rolesById as $roleEntries) {
            $parentRoles = [];
            foreach ($roleEntries as $roleEntry) {
                $parentRoles[] = $roleEntry['parent_role'];
            }
            $role = reset($roleEntries);
            $result[] = [
                'id' => $role['id'],
                'name' => $role['name'],
                'parent' => $parentRoles
            ];
        }
        return $result;
    }
    
    public function getRoleNames()
    {
        $stmt = $this->pdo->prepare('SELECT id,name FROM role');
        $stmt->execute();
        $roles = $stmt->fetchAll();
        $rolesById = [];
        foreach ($roles as $role) {
            $rolesById[$role['id']] = $role['name'];
        }
        return $rolesById;
    }

    public function getRolesAndParent()
    {
        $rolesById = $this->getRoleNames();
        $stmt = $this->pdo->prepare('SELECT r.id,r.name,p.parent_role_id FROM role r LEFT JOIN role_parent_role p ON r.id = p.role_id ORDER BY r.id ASC');
        $stmt->execute();
        $roles = $stmt->fetchAll();
        $result = [];
        foreach ($roles as $role) {
            if (!array_key_exists($role['name'], $result)) {
                $result[$role['name']] = [];
            }
            if ($role['parent_role_id']) {
                $result[$role['name']][] = $rolesById[$role['parent_role_id']];
            }
        }
        return $result;
    }

    public function getPermissionsOfRole($roleId)
    {
        $stmt = $this->pdo->prepare('SELECT permission_id FROM role_permission WHERE role_id = :roleId');
        $stmt->bindParam('roleId', $roleId);
        $stmt->execute();
        $result = [];
        while ($rolePermission = $stmt->fetch()) {
            $result[] = $rolePermission['permission_id'];
        }
        return $result;
    }

    public function setRolePermissions($roleId, $permissions)
    {
        $stmt = $this->pdo->prepare('DELETE FROM role_permission WHERE role_id = :roleId');
        $stmt->bindParam('roleId', $roleId);
        if ($stmt->execute()) {
            $stmt = $this->pdo->prepare('INSERT INTO role_permission VALUES (:roleId, :permissionId)');
            $stmt->bindParam('roleId', $roleId);
            foreach ($permissions as $permission) {
                $stmt->bindParam('permissionId', $permission);
                if (!$stmt->execute()) {
                    return false;
                }
            }
            return true;
        }
    }

    public function getRolePermissions()
    {
        $stmt = $this->pdo->prepare('SELECT r.name as role_name,p.name as permission_name FROM role_permission rp INNER JOIN role r ON rp.role_id = r.id INNER JOIN permission p ON rp.permission_id = p.id');
        $stmt->execute();
        $result = [];
        while ($rolePermission = $stmt->fetch()) {
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
        $stmt = $this->pdo->prepare('INSERT INTO user (username, email, password, role_id) VALUES(:username, :mail, :password, 1)');
        $stmt->bindParam('username', $username);
        $stmt->bindParam('mail', $mail);
        $stmt->bindParam('password', $password);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }
    
    public function createRegisterToken($userId, $token)
    {
        $stmt = $this->pdo->prepare('DELETE FROM register_token WHERE user_id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
        $stmt = $this->pdo->prepare('INSERT INTO register_token (user_id, token) VALUES(:userId, :token)');
        $stmt->bindParam('userId', $userId);
        $stmt->bindParam('token', $token);
        $stmt->execute();
    }

    public function getUserIdByRegisterToken($token)
    {
        $stmt = $this->pdo->prepare('SELECT user_id FROM register_token WHERE token = :token');
        $stmt->bindParam('token', $token);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result['user_id'];
        } else {
            return false;
        }
    }
    
    public function deleteRegisterToken($userId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM register_token WHERE user_id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }
    
    public function createPasswordToken($userId, $token)
    {
        $stmt = $this->pdo->prepare('DELETE FROM password_token WHERE user_id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
        $stmt = $this->pdo->prepare('INSERT INTO password_token (user_id, token) VALUES(:userId, :token)');
        $stmt->bindParam('userId', $userId);
        $stmt->bindParam('token', $token);
        $stmt->execute();
    }

    public function getUserIdByPasswordToken($token)
    {
        $stmt = $this->pdo->prepare('SELECT user_id FROM password_token WHERE token = :token');
        $stmt->bindParam('token', $token);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result['user_id'];
        } else {
            return false;
        }
    }
    
    public function deletePasswordToken($userId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM password_token WHERE user_id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }
    
    public function setPassword($userId, $password)
    {
        $stmt = $this->pdo->prepare('UPDATE user SET password = :password WHERE id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->bindParam('password', $password);
        $stmt->execute();
    }
    
    public function createDeleteToken($userId, $token)
    {
        $stmt = $this->pdo->prepare('DELETE FROM delete_token WHERE user_id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
        $stmt = $this->pdo->prepare('INSERT INTO delete_token (user_id, token) VALUES(:userId, :token)');
        $stmt->bindParam('userId', $userId);
        $stmt->bindParam('token', $token);
        $stmt->execute();
    }
    
    public function getUserIdByDeleteToken($token)
    {
        $stmt = $this->pdo->prepare('SELECT user_id FROM delete_token WHERE token = :token');
        $stmt->bindParam('token', $token);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result['user_id'];
        } else {
            return false;
        }
    }
    
    public function deleteDeleteToken($userId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM delete_token WHERE user_id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }
    
    public function getProfileOptions($offset, $itemCountPerPage)
    {
        $stmt = $this->pdo->prepare('SELECT id,name,input_type as inputType FROM profile_option LIMIT :offset,:itemCountPerPage');
        $stmt->bindParam('offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam('itemCountPerPage', $itemCountPerPage, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }
    
    public function saveProfileOption($data, $id = null)
    {
        $name = $data['name'];
        $inputType = $data['inputType'];
        if ($id) {
            $stmt = $this->pdo->prepare('UPDATE profile_option SET name = :name, input_type = :inputType WHERE id = :id');
            $stmt->bindParam('id', $id);
            $stmt->bindParam('name', $name);
            $stmt->bindParam('inputType', $inputType);
            if ($stmt->execute()) {
                return true;
            }
        } else {
            $stmt = $this->pdo->prepare('INSERT INTO profile_option(name,input_type) VALUES(:name,:inputType)');
            $stmt->bindParam('name', $name);
            $stmt->bindParam('inputType', $inputType);
            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();
            }
        }
    }
    
    public function getProfileOptionData($id)
    {
        $stmt = $this->pdo->prepare('SELECT id,name,input_type as inputType FROM profile_option WHERE id = :id');
        $stmt->bindParam('id', $id);
        if ($stmt->execute()) {
            return $stmt->fetch();
        }
    }
    
    public function deleteProfileOption($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM profile_option WHERE id = :id');
        $stmt->bindParam('id', $id);
        return $stmt->execute();
    }
    
    public function countProfileOptions()
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(id) FROM profile_option');
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
    
    public function getProfileSettings($userId)
    {
        $stmt = $this->pdo->prepare('SELECT o.name,s.value FROM profile_option o LEFT JOIN profile_setting s ON o.id = s.profile_option_id AND s.user_id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }
    
    public function setProfileSettings($userId, array $data)
    {
        $profileOptions = $this->getProfileOptions(0, 100);
        $profileOptionsIdByName = [];
        foreach ($profileOptions as $option) {
            $profileOptionsIdByName[$option['name']] = $option['id'];
        }

        $success = true;
        foreach ($data as $option => $value) {
            $stmt = $this->pdo->prepare('SELECT value FROM profile_setting WHERE user_id = :userId AND profile_option_id = :option');
            $stmt->bindParam('userId', $userId);
            $stmt->bindParam('option', $profileOptionsIdByName[$option]);
            $stmt->execute();
            $dbValue = $stmt->fetch();

            if (!$dbValue) {
                $stmt = $this->pdo->prepare('INSERT INTO profile_setting (user_id, profile_option_id, value) VALUES(:userId, :option, :value)');
                $stmt->bindParam('userId', $userId);
                $stmt->bindParam('option', $profileOptionsIdByName[$option]);
                $stmt->bindParam('value', $value);
                $success = $stmt->execute();
            } elseif ($dbValue['value'] != $value) {
                $stmt = $this->pdo->prepare('UPDATE profile_setting SET value = :value WHERE user_id = :userId AND profile_option_id = :option');
                $stmt->bindParam('userId', $userId);
                $stmt->bindParam('option', $profileOptionsIdByName[$option]);
                $stmt->bindParam('value', $value);
                $success = $stmt->execute();
            }

            if (!$success) {
                break;
            }
        }
        return $success;
    }
    
    public function onUserRoleChanged($userId)
    {
        /* @var $userRoleCache \Zend\Cache\Storage\Adapter\AbstractAdapter */
        $userRoleCache = $this->container->get('UserRoleCache');
        $userRoleCache->removeItem($userId);
    }
}
