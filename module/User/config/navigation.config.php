<?php
return [
    'default' => [
        'user' => [
            'label' => 'user',
            'route' => 'home',
            'order' => 800,
            'pages' => [
                [
                    'label' => 'login',
                    'route' => 'auth/login',
                    'resource' => 'auth/login',
                    'order' => 100
                ],
                [
                    'label' => 'register',
                    'route' => 'auth/register',
                    'resource' => 'auth/register',
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
