<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SectionsFixture
 *
 */
class SectionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'section' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'section_type_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'scout_group_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => 'now()', 'null' => false, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'deleted' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'sections_section' => ['type' => 'unique', 'columns' => ['section'], 'length' => []],
            'sections_scout_group_id_fkey' => ['type' => 'foreign', 'columns' => ['scout_group_id'], 'references' => ['scout_groups', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'sections_section_type_id_fkey' => ['type' => 'foreign', 'columns' => ['section_type_id'], 'references' => ['section_types', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'section' => 'Lorem ipsum dolor sit amet',
                'section_type_id' => 1,
                'scout_group_id' => 1,
                'created' => 1545697629,
                'modified' => 1545697629,
                'deleted' => null,
            ],
            [
                'section' => 'Lorem lla dolor sit amet',
                'section_type_id' => 2,
                'scout_group_id' => 1,
                'created' => 1545697629,
                'modified' => 1545697629,
                'deleted' => null,
            ],
        ];
        parent::init();
    }
}
