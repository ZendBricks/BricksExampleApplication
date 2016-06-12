<?php

namespace Application;

use Zend\ServiceManager\Factory\InvokableFactory;
use Application\Factory\PdoFactory;
use Zend\I18n\Translator\TranslatorServiceFactory;

return [
    'caches' => require 'caches.config.php',
    'console' => require 'console.config.php',
    'router' => require 'router.config.php',
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\ConsoleController::class => Controller\ConsoleControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/403' => __DIR__ . '/../view/error/403.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'pdo' => PdoFactory::class,
            'translator' => TranslatorServiceFactory::class
        ]
    ]
];
