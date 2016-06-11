<?php

namespace User;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use User\Controller\AuthController;

return [
    'routes' => [
        'auth' => [
            'type' => Literal::class,
            'options' => [
                'route' => '/auth',
                'defaults' => [
                    'controller' => AuthController::class
                ]
            ],
            'child_routes' => [
                'login' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/login',
                        'defaults' => [
                            'action' => 'login',
                        ],
                    ],
                ],
                'logout' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/logout',
                        'defaults' => [
                            'action' => 'logout',
                        ],
                    ],
                ],
                'register' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/register',
                        'defaults' => [
                            'action' => 'register',
                        ],
                    ],
                ],
            ]
        ]
    ]
];

