<?php

namespace User\Api;

interface UserApiInterface {
    /**
     * Write $identity into session storage using the key $sessionId
     * 
     * @param string $sessionId should be a secure random generated string
     * @param string $identity in most cases the User-ID
     */
    public function setSessionIdentity($sessionId, $identity);
    
    /**
     * Read the identity from session storage using the key $sessionId
     * 
     * @param string $sessionId should be a secure random generated string
     */
    public function getSessionIdentity($sessionId);
    
    /**
     * Clear the session with $sessionId
     * 
     * @param string $sessionId should be a secure random generated string
     */
    public function clearSessionIdentity($sessionId);

    /**
     * Get the id of a specific user
     * 
     * @param string $username
     * @return int
     */
    public function getIdByUsername($username);
    
    /**
     * @param string $email
     * @return int
     */
    public function getIdByEmail($email);

    /**
     * Get the password-hash of a specific user
     * this will be used for login
     * 
     * @param int|string $userId
     * @return string bcrypt hash of the password
     */
    public function getPasswordById($userId);

    /**
     * @param int|string $userId
     * @return bool
     */
    public function isUserActivated($userId);
    
    /**
     * @param int|string $userId
     */
    public function activateUser($userId);
    
    /**
     * Get the role name of the user
     * 
     * @param string|int $userId
     */
    public function getRoleNameByIdentity($userId);
    
    /**
     * Add a new permission
     * 
     * @param string $name
     */
    public function addPermission($name);
    
    /**
     * returns permissions this way:
     * [
     *     'default/home',
     *     'application/index',
     *     'album/delete'
     * ]
     * 
     * @return array all available permissions
     */
    public function getPermissions();
    
    /**
     * returns roles with parent roles this way:
     * [
     *     'Guest' => [],
     *     'User' => ['Guest'],
     *     'Moderator' => ['User']
     * ]
     * 
     * @return array all available roles
     */
    public function getRoles();

    /**
     * returns granted role - permission combinations this way:
     * [
     *     'Guest' => [
     *         'default/home',
     *         'application/index'
     *     ],
     *     'Moderator' => [
     *         'album/delete'
     *     ]
     * ]
     * 
     * @return array all granted permissions
     */
    public function getRolePermissions();
    
    /**
     * returns granted role - permission combinations this way:
     * [
     *     'User' => [
     *         'auth/login',
     *         'auth/register'
     *     ]
     * ]
     * 
     * @return array all denied permissions
     */
    public function getDeniedRolePermissions();
    
    /**
     * Add an unactivated user
     * 
     * @param string $username
     * @param string $mail
     * @param string $password
     * @return int $userId
     */
    public function registerUser($username, $mail, $password);
    
    /**
     * @param string|int $userId
     * @param string $token
     */
    public function createRegisterToken($userId, $token);
    
    /**
     * @param string $token
     * @return string|int
     */
    public function getUserIdByRegisterToken($token);
            
    /**
     * @param string|int $userId
     */
    public function deleteRegisterToken($userId);
}
