<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2019-01-03
 * Time: 20:55
 */

use App\Model\Entity\Capability as CAP;

return [

    'baseCapabilities' => [
        [
            CAP::FIELD_CAPABILITY_CODE => 'ALL',
            CAP::FIELD_CAPABILITY => 'SuperUser Permissions',
            CAP::FIELD_MIN_LEVEL => 5, // Config Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'DIRECTORY',
            CAP::FIELD_CAPABILITY => 'Use the District Directory',
            CAP::FIELD_MIN_LEVEL => 1, // Section Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'OWN_USER',
            CAP::FIELD_CAPABILITY => 'Edit Own User',
            CAP::FIELD_MIN_LEVEL => 0, // User Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'LOGIN',
            CAP::FIELD_CAPABILITY => 'Login',
            CAP::FIELD_MIN_LEVEL => 0, // Base Level
        ],
    ],

    'entityCapabilities' => [
        'CREATE' => 1,
        'UPDATE' => 1,
        'VIEW' => -5,
        'DELETE' => 5,
    ],

    'allModels' => [
        'Users' => [
            'baseLevel' => 1,
            'viewRestricted' => false,
        ],
        'ScoutGroups' => [
            'baseLevel' => 3,
            'viewRestricted' => false,
        ],
        'Sections' => [
            'baseLevel' => 2,
            'viewRestricted' => false,
        ],
    ],

    'allCapabilities' => [
        'LOGIN',
        'OWN_USER',
    ],
];
