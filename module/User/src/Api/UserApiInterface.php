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
     * @param int|string $userId
     * @return string
     */
    public function getUsernameById($userId);

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
     * @param int|string $userId
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
     * @return int|string $userId
     */
    public function registerUser($username, $mail, $password);
    
    /**
     * Delete all old register tokens of the user and save the new given $token
     * 
     * @param int|string $userId
     * @param string $token
     */
    public function createRegisterToken($userId, $token);
    
    /**
     * @param string $token
     * @return int|string
     */
    public function getUserIdByRegisterToken($token);
            
    /**
     * @param int|string $userId
     */
    public function deleteRegisterToken($userId);
    
    /**
     * @param int|string $userId
     * @param string $token
     */
    public function createPasswordToken($userId, $token);

    /**
     * @param string $token
     * @return int|string
     */
    public function getUserIdByPasswordToken($token);
    
    /**
     * @param int|string $userId
     */
    public function deletePasswordToken($userId);
    
    /**
     * @param int|string $userId
     * @param string $password
     */
    public function setPassword($userId, $password);
}
