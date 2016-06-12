<?php

namespace Application;

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
        'sitemap' => [
            'type' => Literal::class,
            'options' => [
                'route' => '/sitemap.xml',
                'defaults' => [
                    'controller' => Controller\IndexController::class,
                    'action' => 'sitemap',
                ],
            ],
        ],
    ]
];
