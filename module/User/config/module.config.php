<?php

return [
    'router' => require 'router.config.php',
    'controllers' => require 'controllers.config.php',
    'view_manager' => require 'view_manager.config.php',
    'service_manager' => [
        'factories' => [
            'UserApi' => \User\Factory\UserApiFactory::class
        ]
    ]
];
