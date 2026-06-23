<?php

declare(strict_types=1);

use function Hyperf\Support\env;

return [
    'default' => [
        'guard' => 'jwt',
        'provider' => 'admin_users',
    ],

    'guards' => [
        'jwt' => [
            'driver' => 'jwt',
            'provider' => 'admin_users',
            'secret' => env('RBAC_JWT_SECRET', 'maiscms-secret-key-change-me'),
            'algorithm' => 'HS256',
        ],
    ],

    'providers' => [
        'admin_users' => [
            'driver' => 'database',
            'table' => 'admin_users',
        ],
    ],
];
