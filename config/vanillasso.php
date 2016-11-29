<?php

return [
    // The string client ID that you set up in the jsConnect settings page.
    'client_id' => '',

    // The string secred that you set up in the jsConnect settings page.
    'secret' => '',

    // Endpoint
    'endpoint' => 'login/forum',

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
