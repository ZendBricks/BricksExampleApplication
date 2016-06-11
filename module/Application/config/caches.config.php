<?php
return [
    'TranslatorCache' => [
        'adapter' => [
            'name' => 'filesystem'
        ],
        'options' => [
            'cache_dir' => 'data/cache/translator/',
            'dir_permission' => 0777,
            'file_permission' => 0666
        ]
    ]
];