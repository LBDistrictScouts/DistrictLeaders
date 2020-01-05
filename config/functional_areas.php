<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2019-01-03
 * Time: 20:55
 */

return [

    'functionalAreas' => [
        'directory' => [
            'enabled' => true,
            'capability' => [
                'index' => 'DIRECTORY',
            ],
        ],
        'camps' => [
            'enabled' => true,
            'capability' => [
                'index' => 'CAMPS',
            ],
        ],
        'documents' => [
            'enabled' => true,
            'capability' => [
                'index' => 'DOCUMENTS',
            ],
        ],
        'articles' => [
            'enabled' => true,
            'capability' => [
                'index' => 'ARTICLES',
            ],
        ],
        'search' => [
            'enabled' => true,
            'capability' => [
                'index' => 'LOGIN',
            ],
        ],
    ],

    'iconStandards' => [
        'Camps' => 'campground',
        'Directory' => 'address-card',
        'Documents' => 'file-alt',
        'Articles' => 'newspaper',
        'Users' => 'users',
    ],

    'searchConfigured' => [
        'Users' => true,
        'Documents' => true,
    ],
];
