<?php

return [
    'caches' => require 'caches.config.php',
    'controllers' => require 'controllers.config.php',
    'navigation' => require 'navigation.config.php',
    'router' => require 'router.config.php',
    'service_manager' => [
        'factories' => [
            'UserApi' => \User\Api\UserApiFactory::class,
            'Auth' => \User\Auth\AuthServiceFactory::class,
            'Acl' => \User\Auth\AclFactory::class,
        ]
    ],
    'view_manager' => require 'view_manager.config.php',
];
