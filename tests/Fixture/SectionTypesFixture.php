<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SectionTypesFixture
 */
class SectionTypesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'section_type' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'section_type_code' => ['type' => 'string', 'length' => 1, 'default' => 'l', 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'section_types_section_type' => ['type' => 'unique', 'columns' => ['section_type'], 'length' => []],
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
                'section_type' => 'Beavers',
                'section_type_code' => 'l',
            ],
            [
                'section_type' => 'Cubs',
                'section_type_code' => 'l',
            ],
            [
                'section_type' => 'Scouts',
                'section_type_code' => 'l',
            ],
            [
                'section_type' => 'Explorers',
                'section_type_code' => 'l',
            ],
            [
                'section_type' => 'Executive',
                'section_type_code' => 'c',
            ],
            [
                'section_type' => 'Network',
                'section_type_code' => 'l',
            ],
            [
                'section_type' => 'District',
                'section_type_code' => 't',
            ],
            [
                'section_type' => 'Group',
                'section_type_code' => 't',
            ],
        ];
        parent::init();
    }
}
