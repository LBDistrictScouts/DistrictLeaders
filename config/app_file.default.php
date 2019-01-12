<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2019-01-12
 * Time: 11:19
 */
return [
    'Filesystem' => [
        'default' => [
            'adapter' => 'Local', // default
            'adapterArguments' => [ WWW_ROOT . 'files' ]
        ],
        'other' => [
            'adapter' => 'Local',
            'adapterArguments' => [ WWW_ROOT . 'cache' ],
            'entityClass' => '\My\Cool\EntityClass',
            'formatter' => '\My\Cool\Formatter'
        ]
    ]
];