<?php

return [
    [
        'key' => 'wishlist_share',
        'name' => 'wishlist-share::admin.system.title',
        'info' => 'wishlist-share::admin.system.info',
        'sort' => 100,
    ], [
        'key' => 'wishlist_share.settings',
        'name' => 'wishlist-share::admin.system.settings.title',
        'info' => 'wishlist-share::admin.system.settings.info',
        'icon' => 'settings/store.svg',
        'sort' => 1,
    ], [
        'key' => 'wishlist_share.settings.buttons',
        'name' => 'wishlist-share::admin.system.settings.buttons.title',
        'info' => 'wishlist-share::admin.system.settings.buttons.info',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'add_to_wishlist_button_color',
                'title' => 'wishlist-share::admin.system.settings.buttons.add-to-wishlist-color',
                'type' => 'color',
                'default' => '#6b7280',
            ],
            [
                'name' => 'add_to_wishlist_button_label',
                'title' => 'wishlist-share::admin.system.settings.buttons.add-to-wishlist-label',
                'type' => 'text',
                'default' => 'Add to My Wishlist',
            ],
            [
                'name' => 'view_product_button_color',
                'title' => 'wishlist-share::admin.system.settings.buttons.view-product-color',
                'type' => 'color',
                'default' => '#2563eb',
            ],
            [
                'name' => 'view_product_button_label',
                'title' => 'wishlist-share::admin.system.settings.buttons.view-product-label',
                'type' => 'text',
                'default' => 'View Product',
            ],
        ],
    ], [
        'key' => 'wishlist_share.settings.social_sharing',
        'name' => 'wishlist-share::admin.system.settings.social-sharing.title',
        'info' => 'wishlist-share::admin.system.settings.social-sharing.info',
        'sort' => 2,
        'fields' => [
            [
                'name' => 'facebook_button_color',
                'title' => 'wishlist-share::admin.system.settings.social-sharing.facebook-color',
                'type' => 'color',
                'default' => '#1877f2',
            ],
            [
                'name' => 'twitter_button_color',
                'title' => 'wishlist-share::admin.system.settings.social-sharing.twitter-color',
                'type' => 'color',
                'default' => '#1da1f2',
            ],
            [
                'name' => 'linkedin_button_color',
                'title' => 'wishlist-share::admin.system.settings.social-sharing.linkedin-color',
                'type' => 'color',
                'default' => '#0077b5',
            ],
            [
                'name' => 'email_button_color',
                'title' => 'wishlist-share::admin.system.settings.social-sharing.email-color',
                'type' => 'color',
                'default' => '#6b7280',
            ],
            [
                'name' => 'copy_link_button_color',
                'title' => 'wishlist-share::admin.system.settings.social-sharing.copy-link-color',
                'type' => 'color',
                'default' => '#16a34a',
            ],
        ],
    ],
];
