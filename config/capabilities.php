<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2019-01-03
 * Time: 20:55
 */

return [

	'baseCapabilities' => [
		[
			'capability_code' => 'ALL',
			'capability' => 'SuperUser Permissions',
			'min_level' => 5 // Config Level
		],
		[
			'capability_code' => 'EDIT_GROUP',
			'capability' => 'Edit Group',
			'min_level' => 4 // District Level
		],
		[
			'capability_code' => 'ADD_GROUP',
			'capability' => 'Add Group',
			'min_level' => 4 // District Level
		],
		[
			'capability_code' => 'EDIT_SECT',
			'capability' => 'Edit Section',
			'min_level' => 3 // Group Level
		],
		[
			'capability_code' => 'ADD_SECT',
			'capability' => 'Add Section',
			'min_level' => 3 // Group Level
		],
		[
			'capability_code' => 'EDIT_USER',
			'capability' => 'Edit User',
			'min_level' => 2 // Section Level
		],
		[
			'capability_code' => 'ADD_USER',
			'capability' => 'Add New User',
			'min_level' => 2 // Section Level
		],
		[
			'capability_code' => 'OWN_USER',
			'capability' => 'Edit Own User',
			'min_level' => 1 // User Level
		],
		[
			'capability_code' => 'LOGIN',
			'capability' => 'Login',
			'min_level' => 0 // Base Level
		],
	]
];