<?php

namespace User;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'factories' => [
        Controller\AuthController::class => Factory\AuthControllerFactory::class,
        Controller\RoleController::class => InvokableFactory::class,
        Controller\UserController::class => InvokableFactory::class,
    ],
];

