<?php

namespace User\Auth;

use Zend\Authentication\Storage\StorageInterface;
use User\Api\UserApiInterface;

class ApiSessionStorage implements StorageInterface
{
    protected $userApi;
    protected $sessionId;
    protected $sessionIdentity;
    protected $cookieName = 'SESSION_ID';
    protected $cookieLifetime = 2592000;
    protected $sessionIdLength = 26;

    public function __construct(UserApiInterface $userApi) {
        $this->userApi = $userApi;
    }
    
    public function isEmpty()
    {
        return !$this->read();
    }

    public function read()
    {
        if (!$this->sessionIdentity) {
            $this->userApi->getSessionIdentity($this->getSessionId());
        }
        return $this->sessionIdentity;
    }

    public function write($contents)
    {
        $this->userApi->setSessionIdentity($this->getSessionId(), $contents);
    }

    public function clear()
    {
        $this->userApi->clearSessionIdentity($this->getSessionId());
    }
    
    protected function getSessionId()
    {
        if (!$this->sessionId) {
            if (array_key_exists($this->cookieName, $_COOKIE)) {
                $this->sessionId = $_COOKIE[$this->cookieName];
            } else {
                $this->sessionId = $this->getNewSessionId();
                setcookie($this->cookieName, $this->sessionId, time() + $this->cookieLifetime, '/', '');
            }
        }
        return $this->sessionId;
    }
    
    protected function getNewSessionId()
    {
        return openssl_random_pseudo_bytes($this->sessionIdLength);
    }
}
