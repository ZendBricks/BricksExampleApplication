<?php

namespace User;

return [
    'factories' => [
        'UserApi' => Api\UserApiFactory::class,
        'Auth' => Auth\AuthServiceFactory::class,
        'Acl' => Auth\AclFactory::class,
    ]
];
