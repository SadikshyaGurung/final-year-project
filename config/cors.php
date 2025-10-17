<?php
return [

    'paths' => ['api/*','sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:3000','https://joi-unmutant-trickishly.ngrok-free.dev' // another common React URL
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];

