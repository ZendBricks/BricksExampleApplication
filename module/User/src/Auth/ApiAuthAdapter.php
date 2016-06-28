<?php

namespace User\Auth;

use Zend\Authentication\Adapter\AbstractAdapter;
use User\Api\UserApiInterface;
use Zend\Crypt\Password\Bcrypt;
use Zend\Authentication\Result;

class ApiAuthAdapter extends AbstractAdapter
{
    protected $userApi;
    
    public function __construct(UserApiInterface $userApi) {
        $this->userApi = $userApi;
    }

    public function authenticate()
    {
        $bcrypt = new Bcrypt();
        if ($bcrypt->verify($this->getCredential(), $this->userApi->getPasswordById($this->getIdentity()))) {
            $code = Result::SUCCESS;
        } else {
            $code = Result::FAILURE;
        }
        return new Result($code, $this->getIdentity());
    }
}
