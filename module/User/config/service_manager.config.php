<?php

namespace User;

use Zend\Authentication\AuthenticationService;

return [
    'factories' => [
        'UserApi' => Api\UserApiFactory::class,
        AuthenticationService::class => Auth\AuthServiceFactory::class,
        'Acl' => Auth\AclFactory::class,
        'UserMailModel' => Model\UserMailModelFactory::class
    ]
];
