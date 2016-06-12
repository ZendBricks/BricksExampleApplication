<?php

return [
    'modules' => [
        'Zend\ServiceManager\Di',
        'Zend\Session',
        'Zend\Mvc\Plugin\Prg',
        'Zend\Mvc\Plugin\Identity',
        'Zend\Mvc\Plugin\FlashMessenger',
        'Zend\Mvc\Plugin\FilePrg',
        'Zend\Mvc\I18n',
        'Zend\Mvc\Console',
        'Zend\Log',
        'Zend\Form',
        'Zend\Cache',
        'Zend\Router',
        'Zend\Navigation',
        'Zend\I18n',
        'Zend\Validator',
        'Application',
        'User'
    ],
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
        'config_glob_paths' => [
            'config/autoload/{{,*.}global,{,*.}local}.php',
        ],
        'config_cache_enabled' => false,
        'config_cache_key' => 'config.cache',
        'module_map_cache_enabled' => false,
        'module_map_cache_key' => 'module.map.cache',
        'cache_dir' => 'data/cache/',
        'check_dependencies' => true,
    ],
];
