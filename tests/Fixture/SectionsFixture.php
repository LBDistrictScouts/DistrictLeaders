<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SectionsFixture
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
        'section' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'section_type_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'scout_group_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestampfractional', 'length' => null, 'default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => null, 'precision' => 6],
        'modified' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'deleted' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'uuid' => ['type' => 'uuid', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'public' => ['type' => 'boolean', 'length' => null, 'default' => true, 'null' => false, 'comment' => null, 'precision' => null],
        'meeting_day' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'meeting_start_time' => ['type' => 'string', 'length' => 5, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'meeting_end_time' => ['type' => 'string', 'length' => 5, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'sections_section' => ['type' => 'unique', 'columns' => ['section'], 'length' => []],
            'sections_uuid' => ['type' => 'unique', 'columns' => ['uuid'], 'length' => []],
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
    public function init(): void
    {
        $this->records = [
            [
                'section' => 'Lorem ipsum dolor sit amet',
                'section_type_id' => 1,
                'scout_group_id' => 1,
                'created' => 1545697629,
                'modified' => 1545697629,
                'deleted' => null,
                'public' => true,
                'meeting_day' => 3,
                'meeting_start_time' => '18:00',
                'meeting_end_time' => '19:00',
                'uuid' => 'b2da6b3a-e406-4069-bd24-12c28cb816d1',
            ],
            [
                'section' => 'Lorem lla dolor sit amet',
                'section_type_id' => 2,
                'scout_group_id' => 1,
                'created' => 1545697629,
                'modified' => 1545697629,
                'deleted' => null,
                'public' => true,
                'meeting_day' => 1,
                'meeting_start_time' => '20:00',
                'meeting_end_time' => '23:45',
                'uuid' => '969accd0-ea9e-408e-9943-98a54e7bce94',
            ],
        ];
        parent::init();
    }
}
