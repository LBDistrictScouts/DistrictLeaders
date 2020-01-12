<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2019-01-03
 * Time: 20:55
 */

return [

    'dailyCrons' => [
        'UnsentCron' => [
            'daily_schedule' => [
                '+1 hour',
            ],
            'task_name' => 'unsent',
        ],
        'UserPatchCron' => [
            'daily_schedule' => [
                '+1 hour',
                '+7 hour',
                '+13 hour',
                '+19 hour',
            ],
            'task_name' => 'Capability',
        ],
    ],
];
