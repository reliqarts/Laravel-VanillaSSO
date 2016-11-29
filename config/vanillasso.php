<?php

return [
    // The string client ID that you set up in the jsConnect settings page.
    'client_id' => '',

    // The string secred that you set up in the jsConnect settings page.
    'secret' => '',

    // Endpoint
    'endpoint' => 'login/forum',

    // $ecure  Whether or not to check for security. This is one of these values.
    // - true: Check for security and sign the response with an md5 hash.
    // - false: Don't check for security, but sign the response with an md5 hash.
    // - string: Check for security and sign the response with the given hash algorithm. See hash_algos() for what your server can support.
    // - null: Don't check for security and don't sign the response.
    'secure' => true,

    // User profile pic url.
    'profile_pic_url' => 'http://mysite.dev/profile/pic/{user_id}',

    // Route related options.
    'routes' => [
        // Set the bindings for vanillasso
        'bindings' => [
            'middleware' => [
                'web',
                // 'auth',
            ],
        ],
    ],

    // debug mode?
    'debug' => false,
];
