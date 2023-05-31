<?php

return [
    'projects' => [
        ['id' => 1, 'name'=> 'abc'],
        ['id' => 2, 'name'=> 'def'],
        ['id' => 3, 'name'=> 'ghi'],
        ['id' => 4, 'name'=> 'jkl']
    ],

    'folderData' => [
        '20' => [
            '1' => [
                'name' => 'abc',
                'folderName' => 'abc.project.dev',
                'baseUrl' => '',
            ],
            '2' => [
                'name' => 'def',
                'folderName' => 'def.project.dev',
                'baseUrl' => '',
            ],
            '3' => [
                'name' => 'ghi',
                'folderName' => 'ghi.project.dev',
                'baseUrl' => '',
            ],
            '4' => [
                'name' => 'jkl',
                'folderName' => 'jkl.project.dev',
                'baseUrl' => '',
            ]
        ],
        'test' => [
            '1' => [
                'name' => 'abc',
                'folderName' => 'abc.test-project.com',
                'baseUrl' => '../../var/www/html/',
            ],
            '2' => [
                'name' => 'def',
                'folderName' => 'def.test-project.com',
                'baseUrl' => '../../var/www/html/',
            ],
            '3' => [
                'name' => 'ghi',
                'folderName' => 'ghi.test-project.com',
                'baseUrl' => '../../var/www/html/',
            ],
            '4' => [
                'name' => 'jkl',
                'folderName' => 'jkl.test-project.com',
                'baseUrl' => '../../var/www/html/',
            ]
        ],
        'staging' => [
            '1' => [
                'name' => 'abc',
                'folderName' => 'stagingabc.project.com',
                'baseUrl' => '../../var/www/html/',
            ],
            '2' => [
                'name' => 'def',
                'folderName' => 'stagingdef.project.com',
                'baseUrl' => '../../var/www/html/',
            ],
            '3' => [
                'name' => 'ghi',
                'folderName' => '',
                'baseUrl' => '../../var/www/html/',
            ],
            '4' => [
                'name' => 'jkl',
                'folderName' => 'jkl.staging-project.com',
                'baseUrl' => '../../var/www/html/',
            ]
        ]
    ],

    'commands' => [
        1 => 'git pull',
        2 => 'php artisan optimize:clear'
    ],

    'serverCredantial' => [
        '20' => [
            'host' => '',
            'port' => '',
            'user' => '',
            'password' => '',
        ],
        'test' => [
            'host' => '',
            'port' => '',
            'user' => '',
            'password' => '',
        ],
        'staging' => [
            'host' => '',
            'port' => '',
            'user' => '',
            'password' => '',
        ],
    ]

];
