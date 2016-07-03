<?php

namespace User;

use ZendBricks\BricksUser\Api\UserApiInterface;

return [
    'service_manager' => [
        'factories' => [
            UserApiInterface::SERVICE_NAME => Api\UserApiFactory::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
