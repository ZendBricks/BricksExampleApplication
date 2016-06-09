<?php

namespace User\Api;

class UserApi implements ApiInterface
{
    protected $pdo;
    
    public function __construct(\PDO $pdo)
    {
        $this->pdo;
    }
}
