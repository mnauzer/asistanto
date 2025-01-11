<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://localhost:3001',
        'http://localhost:3002',
        'http://localhost:3003',
        'http://reddwarf:3001',
        'http://reddwarf:3002',
        'http://reddwarf:3003'
    ],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
