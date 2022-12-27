<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentEditionsFixture
 */
class DocumentEditionsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'created' => ['type' => 'timestamptimezone', 'length' => null, 'default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => null, 'precision' => 6],
        'modified' => ['type' => 'timestamptimezone', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'deleted' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'document_version_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'file_type_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'file_path' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'filename' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'size' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'md5_hash' => ['type' => 'string', 'length' => 40, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'document_editions_file_type_id_document_version_id' => ['type' => 'unique', 'columns' => ['document_version_id', 'file_type_id'], 'length' => []],
            'document_editions_document_version_id_fkey' => ['type' => 'foreign', 'columns' => ['document_version_id'], 'references' => ['document_versions', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'document_editions_file_type_id_fkey' => ['type' => 'foreign', 'columns' => ['file_type_id'], 'references' => ['file_types', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'created' => 1575923177,
                'modified' => 1575923177,
                'deleted' => null,
                'document_version_id' => 1,
                'file_type_id' => 1,
                'md5_hash' => 'Lorem ipsum dolor sit amet',
                'file_path' => 'Lorem ipsum dolor sit amet',
                'filename' => 'Lorem ipsum dolor sit amet',
                'size' => 1,
            ],
        ];
        parent::init();
    }
}
