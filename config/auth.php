<?php

return [
    'providers'=>[
        'admins' => [
            'driver' => 'eloquent',
            'model'  => BajakLautMalaka\PmiAdmin\Admin::class
        ]
    ],
    'guards' => [
        'admin' => [
            'driver' => 'passport',
            'provider' => 'admins',
        ]
    ],
    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60
        ]
    ]
];
