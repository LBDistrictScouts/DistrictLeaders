<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DirectoryGroupsFixture
 */
class DirectoryGroupsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'directory_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'directory_group_name' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'directory_group_email' => ['type' => 'string', 'length' => 100, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'directory_group_reference' => ['type' => 'string', 'length' => 64, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'directory_groups_directory_group_email' => ['type' => 'unique', 'columns' => ['directory_group_email'], 'length' => []],
            'directory_groups_directory_group_reference' => ['type' => 'unique', 'columns' => ['directory_group_reference'], 'length' => []],
            'directory_groups_directory_id_fkey' => ['type' => 'foreign', 'columns' => ['directory_id'], 'references' => ['directories', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'id' => 1,
                'directory_id' => 1,
                'directory_group_name' => 'Lorem ipsum dolor sit amet',
                'directory_group_email' => 'Lorem ipsum dolor sit amet',
                'directory_group_reference' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
