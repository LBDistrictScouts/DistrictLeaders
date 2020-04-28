<?php
return [

    'elasticEnv' => 'travis',

    /**
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * ### Notes
     * - Drivers include Mysql Postgres Sqlite Sqlserver
     *   See vendor\cakephp\cakephp\src\Database\Driver for complete list
     * - Do not use periods in database name - it may lead to error.
     *   See https://github.com/cakephp/cakephp/issues/6471 for details.
     * - 'encoding' is recommended to be set to full UTF-8 4-Byte support.
     *   E.g set it to 'utf8mb4' in MariaDB and MySQL and 'utf8' for any
     *   other RDBMS.
     */
    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Postgres',
            'persistent' => false,
            'host' => '127.0.0.1',
//            'port' => '5433',
            'username' => 'postgres',
            'password' => '',
            'database' => 'leaders',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => true,
        ],

        'database_log' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Postgres',
            'persistent' => false,
            'host' => '127.0.0.1',
//            'port' => '5433',
            'username' => 'postgres',
            'password' => '',
            'database' => 'leaders',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false, // DataSource to use
        ],

        /**
         * The test connection is used during the test suite.
         */
        'test' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Postgres',
            'persistent' => false,
            'host' => '127.0.0.1',
//            'port' => '5433',
            'username' => 'postgres',
            'password' => '',
            'database' => 'leaders',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => true,
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
        ],

        'elastic' => [
            'className' => 'Cake\ElasticSearch\Datasource\Connection',
            'driver' => 'Cake\ElasticSearch\Datasource\Connection',
            'host' => '127.0.0.1',
            'port' => 9200,
            'index' => 'my_apps_index',
        ],

        'test_elastic' => [
            'className' => 'Cake\ElasticSearch\Datasource\Connection',
            'driver' => 'Cake\ElasticSearch\Datasource\Connection',
            'host' => '127.0.0.1',
            'port' => 9200,
            'index' => 'my_apps_index',
        ],

        'test_database_log' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Postgres',
            'persistent' => false,
            'host' => '127.0.0.1',
//            'port' => '5433',
            'username' => 'postgres',
            'password' => '',
            'database' => 'leaders',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false, // DataSource to use
        ],

        'debug_kit' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Sqlite',
            'database' => TMP . 'debug_kit.sqlite',
            'encoding' => 'utf8',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
        ],

        'test_debug_kit' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Sqlite',
            'database' => TMP . DS . 'tests' . DS . 'debug_kit.sqlite',
            'encoding' => 'utf8',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
        ],
    ],
];
