<?php
return [
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
			'host' => 'localhost',
			'port' => '5432',
			'username' => 'jacob',
			'password' => '',
			'database' => 'district_leader',
			'schema' => 'leader',
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
			'host' => 'localhost',
			'port' => '5432',
			'username' => 'jacob',
			'password' => '',
			'database' => 'district_leader',
			'schema' => 'log',
			'encoding' => 'utf8',
			'timezone' => 'UTC',
			'cacheMetadata' => true,
			'quoteIdentifiers' => false,
			'log' => true, // DataSource to use
		],

		'test' => [
			'className' => 'Cake\Database\Connection',
			'driver' => 'Cake\Database\Driver\Postgres',
			'persistent' => false,
			'host' => 'localhost',
			'port' => '5432',
			'username' => 'jacob',
			'password' => '',
			'database' => 'district_leader',
			'schema' => 'test',
			'encoding' => 'utf8',
			'timezone' => 'UTC',
			'cacheMetadata' => true,
			'quoteIdentifiers' => false,
			'log' => true,
			//'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
		],

		'test_database_log' => [
			'className' => 'Cake\Database\Connection',
			'driver' => 'Cake\Database\Driver\Postgres',
			'persistent' => false,
			'host' => 'localhost',
			'port' => '5432',
			'username' => 'jacob',
			'password' => '',
			'database' => 'district_leader',
			'schema' => 'test_log',
			'encoding' => 'utf8',
			'timezone' => 'UTC',
			'cacheMetadata' => true,
			'quoteIdentifiers' => false,
			'log' => true, // DataSource to use
		],
	],
];
