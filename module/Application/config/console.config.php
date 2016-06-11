<?php

namespace Application;

return [
    'router' => [
        'routes' => [
            'clear-cache' => [
                'options' => [
                    'route'    => 'clear-cache',
                    'defaults' => [
                        'controller' => Controller\ConsoleController::class,
                        'action' => 'clearCache'
                    ]
                ]
            ],
        ]
    ]
];