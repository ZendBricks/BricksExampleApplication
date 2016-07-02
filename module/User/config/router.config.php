<?php

namespace User;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use User\Controller\AuthController;

return [
    'router_class' => \Zend\Mvc\I18n\Router\TranslatorAwareTreeRouteStack::class,
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
                'confirmRegistration' => [
                    'type' => Segment::class,
                    'options' => [
                        'route' => '/confirm-registration/:token',
                        'defaults' => [
                            'action' => 'confirmRegistration',
                        ],
                    ],
                ],
                'resendRegisterMail' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/resend-register-mail',
                        'defaults' => [
                            'action' => 'resendRegisterMail',
                        ],
                    ],
                ],
                'forgotPassword' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/forgot-password',
                        'defaults' => [
                            'action' => 'forgotPassword',
                        ],
                    ],
                ],
                'changePassword' => [
                    'type' => Segment::class,
                    'options' => [
                        'route' => '/change-password[/:token]',
                        'defaults' => [
                            'action' => 'changePassword',
                        ],
                    ],
                ],
                'selfDelete' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/self-delete',
                        'defaults' => [
                            'action' => 'selfDelete',
                        ],
                    ],
                ],
                'confirmSelfDelete' => [
                    'type' => Segment::class,
                    'options' => [
                        'route' => '/confirm-self-delete/:token',
                        'defaults' => [
                            'action' => 'confirmSelfDelete',
                        ],
                    ],
                ]
            ]
        ]
    ]
];

