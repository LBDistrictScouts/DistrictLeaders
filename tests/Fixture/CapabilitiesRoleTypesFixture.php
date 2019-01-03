<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CapabilitiesRoleTypesFixture
 *
 */
class CapabilitiesRoleTypesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'capability_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'role_type_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['capability_id', 'role_type_id'], 'length' => []],
            'capabilities_role_types_capability_id_fkey' => ['type' => 'foreign', 'columns' => ['capability_id'], 'references' => ['capabilities', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'capabilities_role_types_role_type_id_fkey' => ['type' => 'foreign', 'columns' => ['role_type_id'], 'references' => ['role_types', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'capability_id' => 1, // Level 5
                'role_type_id' => 5
            ],
            [
                'capability_id' => 2, // Level 4
                'role_type_id' => 4
            ],
            [
                'capability_id' => 3, // Level 3
                'role_type_id' => 3
            ],
            [
                'capability_id' => 4, // Level 2
                'role_type_id' => 2
            ],
            [
                'capability_id' => 5, // Level 1
                'role_type_id' => 1
            ],
	        [
		        'capability_id' => 6, // Level 0
		        'role_type_id' => 5
	        ],
	        [
		        'capability_id' => 6, // Level 0
		        'role_type_id' => 4
	        ],
	        [
		        'capability_id' => 6, // Level 0
		        'role_type_id' => 3
	        ],
	        [
		        'capability_id' => 6, // Level 0
		        'role_type_id' => 2
	        ],
	        [
		        'capability_id' => 6, // Level 0
		        'role_type_id' => 1
	        ],
        ];
        parent::init();
    }
}
