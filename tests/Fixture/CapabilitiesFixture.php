<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CapabilitiesFixture
 *
 */
class CapabilitiesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'capability_code' => ['type' => 'string', 'length' => 10, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'capability' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'min_level' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'capabilities_capability_code' => ['type' => 'unique', 'columns' => ['capability_code'], 'length' => []],
            'capabilities_capability' => ['type' => 'unique', 'columns' => ['capability'], 'length' => []],
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
                'capability_code' => 'EDIT_SECT',
                'capability' => 'Edit Section',
                'min_level' => 3 // Group Level
            ],
            [
                'capability_code' => 'EDIT_USER',
                'capability' => 'Edit User',
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
        ];
        parent::init();
    }
}
