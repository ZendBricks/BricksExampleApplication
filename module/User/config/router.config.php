<?php

namespace User;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'routes' => [
        'home' => [
            'type' => Literal::class,
            'options' => [
                'route' => '/',
                'defaults' => [
                    'controller' => Controller\IndexController::class,
                    'action' => 'index',
                ],
            ],
        ],
        'application' => [
            'type' => Segment::class,
            'options' => [
                'route' => '/application[/:action]',
                'defaults' => [
                    'controller' => Controller\IndexController::class,
                    'action' => 'index',
                ],
            ],
        ],
    ]
];

