<?php
return [
    'default' => [
        'user' => [
            'label' => 'user',
            'route' => 'home',
            'order' => 800,
            'pages' => [
                [
                    'label' => 'register',
                    'route' => 'auth/register',
                    'resource' => 'auth/register',
                    'order' => 100
                ],
                [
                    'label' => 'login',
                    'route' => 'auth/login',
                    'resource' => 'login',
                    'order' => 200
                ],
                [
                    'label' => 'logout',
                    'route' => 'auth/logout',
                    'resource' => 'auth/logout',
                    'order' => 200
                ],
            ]
        ]
    ]
];
