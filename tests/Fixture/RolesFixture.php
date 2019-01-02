<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RolesFixture
 *
 */
class RolesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'role_type_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'section_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'user_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'role_status_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => 'now()', 'null' => false, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'deleted' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        '_indexes' => [
            'roles_role_type_id' => ['type' => 'index', 'columns' => ['role_type_id'], 'length' => []],
            'roles_section_id' => ['type' => 'index', 'columns' => ['section_id'], 'length' => []],
            'roles_user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'roles_role_status_id' => ['type' => 'index', 'columns' => ['role_status_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'roles_role_status_id_fkey' => ['type' => 'foreign', 'columns' => ['role_status_id'], 'references' => ['role_statuses', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'roles_role_type_id_fkey' => ['type' => 'foreign', 'columns' => ['role_type_id'], 'references' => ['role_types', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'roles_section_id_fkey' => ['type' => 'foreign', 'columns' => ['section_id'], 'references' => ['sections', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'roles_user_id_fkey' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'role_type_id' => 1,
                'section_id' => 1,
                'user_id' => 1,
                'role_status_id' => 1,
                'created' => 1545697703,
                'modified' => 1545697703,
                'deleted' => null,
            ],
            [
                'role_type_id' => 2,
                'section_id' => 1,
                'user_id' => 1,
                'role_status_id' => 1,
                'created' => 1545697703,
                'modified' => 1545697703,
                'deleted' => null,
            ],
            [
                'role_type_id' => 3,
                'section_id' => 1,
                'user_id' => 1,
                'role_status_id' => 1,
                'created' => 1545697703,
                'modified' => 1545697703,
                'deleted' => null,
            ],
            [
                'role_type_id' => 4,
                'section_id' => 1,
                'user_id' => 1,
                'role_status_id' => 1,
                'created' => 1545697703,
                'modified' => 1545697703,
                'deleted' => null,
            ],
            [
                'role_type_id' => 5,
                'section_id' => 1,
                'user_id' => 1,
                'role_status_id' => 1,
                'created' => 1545697703,
                'modified' => 1545697703,
                'deleted' => null,
            ],
            [
                'role_type_id' => 6,
                'section_id' => 1,
                'user_id' => 1,
                'role_status_id' => 1,
                'created' => 1545697703,
                'modified' => 1545697703,
                'deleted' => null,
            ],
            [
                'role_type_id' => 3,
                'section_id' => 1,
                'user_id' => 2,
                'role_status_id' => 1,
                'created' => 1545697703,
                'modified' => 1545697703,
                'deleted' => null,
            ],
            [
                'role_type_id' => 2,
                'section_id' => 2,
                'user_id' => 2,
                'role_status_id' => 1,
                'created' => 1545697703,
                'modified' => 1545697703,
                'deleted' => null,
            ],
            [
                'role_type_id' => 2,
                'section_id' => 1,
                'user_id' => 2,
                'role_status_id' => 1,
                'created' => 1545697703,
                'modified' => 1545697703,
                'deleted' => null,
            ],
        ];
        parent::init();
    }
}
