<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentsFixture
 */
class DocumentsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'document_type_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestamptimezone', 'length' => null, 'default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => null, 'precision' => 6],
        'modified' => ['type' => 'timestamptimezone', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'deleted' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'document' => ['type' => 'string', 'length' => 255, 'default' => 'null', 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'document_preview_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'latest_version' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'documents_document' => ['type' => 'unique', 'columns' => ['document'], 'length' => []],
            'documents_document_type_id_fkey' => ['type' => 'foreign', 'columns' => ['document_type_id'], 'references' => ['document_types', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'document_type_id' => 1,
                'created' => 1572792427,
                'modified' => 1572792427,
                'deleted' => null,
                'document' => 'Lorem ipsum dolor sit amet',
                'document_preview_id' => 1,
                'latest_version' => 1,
            ],
        ];
        parent::init();
    }
}
