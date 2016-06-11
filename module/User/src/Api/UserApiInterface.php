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
     * Get the password-hash of a specific user
     * this will be used for login
     * 
     * @param string $username
     * @return string bcrypt hash of the password
     */
    public function getPasswordByUsername($username);

    /**
     * Get the role name of the user
     * 
     * @param string|int $userId
     */
    public function getRoleNameByIdentity($userId);
    
    /**
     * returns permissions this way:
     * [
     *     'default/home',
     *     'application/index',
     *     'album/delete'
     * ]
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
     * @return array all available roles
     */
    public function getRoles();

    /**
     * returns granted role - permission combinations this way:
     * [
     *     'Guest' => 'default/home',
     *     'Guest' => 'application/index',
     *     'Moderator' => 'album/delete'
     * ]
     * @return array all granted permissions
     */
    public function getRolePermissions();
}
