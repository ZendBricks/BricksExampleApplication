<?php
return [
    'default' => [
        [
            'label' => 'Register',
            'route' => 'auth/register',
            'resource' => 'auth/register',
            'order' => 800
        ],
        [
            'label' => 'Login',
            'route' => 'auth/login',
            'resource' => 'auth/login',
            'order' => 810
        ],
        [
            'label' => 'Logout',
            'route' => 'auth/logout',
            'resource' => 'auth/logout',
            'order' => 820
        ],
    ]
];
