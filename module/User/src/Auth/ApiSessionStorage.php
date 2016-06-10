<?php

namespace User\Auth;

use Zend\Authentication\Storage\StorageInterface;
use User\Api\UserApi;

class ApiSessionStorage implements StorageInterface
{
    protected $userApi;
    
    public function __construct(UserApi $userApi) {
        $this->userApi = $userApi;
    }
    
    public function isEmpty()
    {
        
    }

    public function read()
    {
        
    }

    public function write($contents)
    {
        
    }

    public function clear()
    {
        
    }
}
