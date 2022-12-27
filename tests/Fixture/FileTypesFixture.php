<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FileTypesFixture
 */
class FileTypesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'file_type' => ['type' => 'string', 'length' => 31, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'file_extension' => ['type' => 'string', 'length' => 10, 'default' => 'null', 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'mime' => ['type' => 'string', 'length' => 32, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'file_types_file_type' => ['type' => 'unique', 'columns' => ['file_type'], 'length' => []],
            'file_types_file_extension' => ['type' => 'unique', 'columns' => ['file_extension'], 'length' => []],
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
                'file_type' => 'Word',
                'file_extension' => 'docx',
                'mime' => 'application/docx',
            ],
            [
                'file_type' => 'PDF',
                'file_extension' => 'pdf',
                'mime' => 'application/pdf',
            ],
        ];
        parent::init();
    }
}
