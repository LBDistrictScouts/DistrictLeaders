<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SectionTypesFixture
 *
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
        'section_type' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
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
            ],
            [
                'section_type' => 'Cubs',
            ],
            [
                'section_type' => 'Scouts',
            ],
            [
                'section_type' => 'Explorers',
            ],
            [
                'section_type' => 'Executive',
            ],
            [
                'section_type' => 'Network',
            ],
            [
                'section_type' => 'District',
            ],
            [
                'section_type' => 'Group',
            ],
        ];
        parent::init();
    }
}
