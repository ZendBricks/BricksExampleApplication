<?php

namespace User;

use ZendBricks\BricksUser\Api\UserApiInterface;

return [
    'service_manager' => [
        'factories' => [
            UserApiInterface::SERVICE_NAME => Api\UserApiFactory::class
        ]
    ]
];
