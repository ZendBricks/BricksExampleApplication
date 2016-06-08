<?php

namespace User\Api;

class Api implements ApiInterface
{
    protected $pdo;
    
    public function __construct(\PDO $pdo)
    {
        $this->pdo;
    }
}
