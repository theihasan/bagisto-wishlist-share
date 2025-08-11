<?php

return [
    'enabled' => true,

    'social_platforms' => [
        'facebook' => [
            'enabled' => true,
            'url' => 'https://www.facebook.com/sharer/sharer.php?u=',
        ],
        'twitter' => [
            'enabled' => true,
            'url' => 'https://twitter.com/intent/tweet?url=',
        ],
        'linkedin' => [
            'enabled' => true,
            'url' => 'https://www.linkedin.com/sharing/share-offsite/?url=',
        ],
        'email' => [
            'enabled' => true,
            'subject' => 'Check out my wishlist',
        ],
    ],

    'qr_code' => [
        'enabled' => true,
        'size' => 200,
        'margin' => 10,
    ],

    'share_token' => [
        'length' => 32,
        'expires_in_days' => 30,
    ],
];
