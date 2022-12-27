<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ScoutGroupsFixture
 */
class ScoutGroupsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'scout_group' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'group_alias' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'number_stripped' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'charity_number' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'group_domain' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'created' => ['type' => 'timestampfractional', 'length' => null, 'default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => null, 'precision' => 6],
        'modified' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'deleted' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'uuid' => ['type' => 'uuid', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'public' => ['type' => 'boolean', 'length' => null, 'default' => 1, 'null' => false, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'scout_groups_scout_group' => ['type' => 'unique', 'columns' => ['scout_group'], 'length' => []],
            'scout_groups_uuid' => ['type' => 'unique', 'columns' => ['uuid'], 'length' => []],
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
                'scout_group' => '4th Goat Town',
                'group_alias' => '4th Goat',
                'number_stripped' => 4,
                'charity_number' => 134,
                'group_domain' => '4thgoat.org.uk',
                'created' => 1545697609,
                'modified' => 1545697609,
                'deleted' => null,
                'public' => true,
                'uuid' => '000ee8ce-437f-46c4-a47d-0dca30cf2f12',
            ],
            [
                'scout_group' => '8th FishTown Substantial',
                'group_alias' => '8th Fish',
                'number_stripped' => 8,
                'charity_number' => 187,
                'group_domain' => '8thfish.co.uk',
                'created' => 1545697609,
                'modified' => 1545697609,
                'deleted' => null,
                'public' => true,
                'uuid' => '732466ff-9437-44bb-bf99-c41ffecdb2cb',
            ],
        ];
        parent::init();
    }
}
