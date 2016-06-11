<?php
return [
    'AclCache' => [
        'adapter' => [
            'name' => 'filesystem'
        ],
        'options' => [
            'cache_dir' => 'data/cache/acl/',
            'dir_permission' => 0777,
            'file_permission' => 0666
        ],
        'plugins' => [
            'serializer'
        ]
    ],
    'UserRoleCache' => [
        'adapter' => [
            'name' => 'filesystem'
        ],
        'options' => [
            'cache_dir' => 'data/cache/user-role/',
            'dir_permission' => 0777,
            'file_permission' => 0666
        ]
    ]
];