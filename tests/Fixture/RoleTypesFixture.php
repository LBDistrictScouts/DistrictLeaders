<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RoleTypesFixture
 */
class RoleTypesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'role_type' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'role_abbreviation' => ['type' => 'string', 'length' => 32, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'section_type_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'level' => ['type' => 'integer', 'length' => 10, 'default' => '1', 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'role_template_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'role_types_role_template_id_fkey' => ['type' => 'foreign', 'columns' => ['role_template_id'], 'references' => ['role_templates', 'id'], 'update' => 'setNull', 'delete' => 'setNull', 'length' => []],
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
                'role_type' => 'Lorem ipsum dolor sit amet',
                'role_abbreviation' => 'Lorem ipsum dolor sit amet',
                'section_type_id' => 1,
                'level' => 1,
                'role_template_id' => 1,
            ],
            [
                'role_type' => 'Lorem ipsum dolor sit amet',
                'role_abbreviation' => 'Lorem ipsum dolor sit amet',
                'section_type_id' => 1,
                'level' => 2,
                'role_template_id' => 1,
            ],
            [
                'role_type' => 'Lorem ipsum dolor sit amet',
                'role_abbreviation' => 'Lorem ipsum dolor sit amet',
                'section_type_id' => 1,
                'level' => 3,
                'role_template_id' => 1,
            ],
            [
                'role_type' => 'Lorem ipsum dolor sit amet',
                'role_abbreviation' => 'Lorem ipsum dolor sit amet',
                'section_type_id' => 1,
                'level' => 4,
                'role_template_id' => 1,
            ],
            [
                'role_type' => 'Lorem ipsum dolor sit amet',
                'role_abbreviation' => 'Lorem ipsum dolor sit amet',
                'section_type_id' => 1,
                'level' => 5,
                'role_template_id' => 1,
            ],
            [
                'role_type' => 'Lorem ipsum dolor sit amet',
                'role_abbreviation' => 'Lorem ipsum dolor sit amet',
                'section_type_id' => 1,
                'level' => 0,
                'role_template_id' => 1,
            ],
            [
                'role_type' => 'Lorem ipsum  sit amet',
                'role_abbreviation' => 'Lorem  dolor sit amet',
                'section_type_id' => 1,
                'level' => 0,
                'role_template_id' => 1,
            ],
        ];
        parent::init();
    }
}
