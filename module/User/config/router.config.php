<?php

namespace User;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use User\Controller\AuthController;

return [
    'routes' => [
        'login' => [
            'type' => Literal::class,
            'options' => [
                'route' => '/login',
                'defaults' => [
                    'controller' => AuthController::class,
                    'action' => 'login',
                ],
            ],
        ],
        'logout' => [
            'type' => Literal::class,
            'options' => [
                'route' => '/logout',
                'defaults' => [
                    'controller' => AuthController::class,
                    'action' => 'logout',
                ],
            ],
        ],
        'register' => [
            'type' => Literal::class,
            'options' => [
                'route' => '/register',
                'defaults' => [
                    'controller' => AuthController::class,
                    'action' => 'register',
                ],
            ],
        ],
    ]
];

