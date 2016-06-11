<?php

namespace User\Auth;

use Zend\Authentication\Adapter\AbstractAdapter;
use User\Api\UserApiInterface;
use Zend\Crypt\Password\Bcrypt;

class ApiAuthAdapter extends AbstractAdapter
{
    protected $userApi;
    
    public function __construct(UserApiInterface $userApi) {
        $this->userApi = $userApi;
    }

    public function authenticate()
    {
        $bcrypt = new Bcrypt();
        return $bcrypt->verify($this->getCredential(), $this->userApi->getPasswordByUsername($this->getIdentity()));
    }
}
