<?php

namespace User;

return [
    'router' => [
        'routes' => [
            'add-permissions' => [
                'options' => [
                    'route'    => 'add-permissions',
                    'defaults' => [
                        'controller' => Controller\ConsoleController::class,
                        'action' => 'addPermissions'
                    ]
                ]
            ],
        ]
    ]
];