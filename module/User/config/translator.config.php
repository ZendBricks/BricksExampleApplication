<?php
return [
    'translation_file_patterns' => [
        [
            'type' => 'phparray',
            'base_dir' => __DIR__ . '/../language',
            'pattern' => '%s.php',
        ],
        [
            'type' => 'gettext',
            'base_dir' => __DIR__ . '/../language',
            'pattern' => '%s.mo',
        ]
    ]
];

