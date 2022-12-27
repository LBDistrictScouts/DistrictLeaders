<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RoleTypesDirectoryGroupsFixture
 */
class RoleTypesDirectoryGroupsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'directory_group_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'role_type_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['directory_group_id', 'role_type_id'], 'length' => []],
            'role_types_directory_groups_directory_group_id_fkey' => ['type' => 'foreign', 'columns' => ['directory_group_id'], 'references' => ['directory_groups', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'role_types_directory_groups_role_type_id_fkey' => ['type' => 'foreign', 'columns' => ['role_type_id'], 'references' => ['role_types', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'directory_group_id' => 1,
                'role_type_id' => 1,
            ],
        ];
        parent::init();
    }
}
