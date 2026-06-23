<?php

declare(strict_types=1);

use function Hyperf\Support\env;

return [
    'default' => [
        'hasher' => 'bcrypt',
        'encrypter' => 'openssl',
    ],

    'hashers' => [
        'bcrypt' => [
            'driver' => 'bcrypt',
            'cost' => 12,
        ],
        'argon2' => [
            'driver' => 'argon2',
        ],
        'sodium' => [
            'driver' => 'sodium',
        ],
    ],

    'encrypters' => [
        'openssl' => [
            'driver' => 'openssl',
            'key' => env('CRYPTO_OPENSSL_KEY', 'base64:Y2hhbmdlLXRoaXMtdG8tYS1yZWFsLWtleQ=='),
            'cipher' => 'aes-256-gcm',
        ],
        'aes-cbc' => [
            'driver' => 'aes-cbc',
            'key' => env('CRYPTO_AES_CBC_KEY', 'base64:Y2hhbmdlLXRoaXMtdG8tYS1yZWFsLWtleQ=='),
            'cipher' => 'aes-256-cbc',
        ],
        'sodium' => [
            'driver' => 'sodium',
            'key' => env('CRYPTO_SODIUM_KEY', 'base64:Y2hhbmdlLXRoaXMtdG8tYS1yZWFsLWtleQ=='),
        ],
        'rsa' => [
            'driver' => 'rsa',
            'private_key' => env('CRYPTO_RSA_PRIVATE_KEY', ''),
            'public_key' => env('CRYPTO_RSA_PUBLIC_KEY', ''),
            'padding' => 'oaep',
            'sign_algo' => 'sha256',
        ],
    ],
];
