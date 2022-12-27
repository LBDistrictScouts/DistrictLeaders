<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentTypesFixture
 */
class DocumentTypesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'document_type' => ['type' => 'string', 'length' => 31, 'default' => 'null', 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'special_capability' => ['type' => 'string', 'length' => 64, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'document_types_document_type' => ['type' => 'unique', 'columns' => ['document_type'], 'length' => []],
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
                'document_type' => 'Lorem ipsum dolor sit amet',
                'special_capability' => 'HISTORY',
            ],
        ];
        parent::init();
    }
}
