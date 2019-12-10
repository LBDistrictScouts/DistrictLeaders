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
            CAP::FIELD_MIN_LEVEL => 5 // Config Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'EDIT_GROUP',
            CAP::FIELD_CAPABILITY => 'Edit Group',
            CAP::FIELD_MIN_LEVEL => 4 // District Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'ADD_GROUP',
            CAP::FIELD_CAPABILITY => 'Add Group',
            CAP::FIELD_MIN_LEVEL => 4 // District Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'EDIT_SECT',
            CAP::FIELD_CAPABILITY => 'Edit Section',
            CAP::FIELD_MIN_LEVEL => 3 // Group Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'ADD_SECT',
            CAP::FIELD_CAPABILITY => 'Add Section',
            CAP::FIELD_MIN_LEVEL => 3 // Group Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'EDIT_USER',
            CAP::FIELD_CAPABILITY => 'Edit User',
            CAP::FIELD_MIN_LEVEL => 2 // Section Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'ADD_USER',
            CAP::FIELD_CAPABILITY => 'Add New User',
            CAP::FIELD_MIN_LEVEL => 2 // Section Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'DIRECTORY',
            CAP::FIELD_CAPABILITY => 'Use the District Directory',
            CAP::FIELD_MIN_LEVEL => 1 // Section Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'OWN_USER',
            CAP::FIELD_CAPABILITY => 'Edit Own User',
            CAP::FIELD_MIN_LEVEL => 1 // User Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'LOGIN',
            CAP::FIELD_CAPABILITY => 'Login',
            CAP::FIELD_MIN_LEVEL => 0 // Base Level
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'CH_DOCTYPE',
            CAP::FIELD_CAPABILITY => 'Change Doc Types',
            CAP::FIELD_MIN_LEVEL => 3
        ],
        [
            CAP::FIELD_CAPABILITY_CODE => 'DEL_USER',
            CAP::FIELD_CAPABILITY => 'Delete User',
            CAP::FIELD_MIN_LEVEL => 4 // District Level
        ],
    ],

    'allCapabilities' => [
        'LOGIN',
        'OWN_USER',
    ]
];
