<?php

return [
    'modules' => require 'modules.config.php',
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
