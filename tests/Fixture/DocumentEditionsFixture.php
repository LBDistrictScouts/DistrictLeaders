<?php
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
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'deleted' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'document_version_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'file_type_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
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
    public function init()
    {
        $this->records = [
            [
                'created' => 1572792449,
                'modified' => 1572792449,
                'deleted' => null,
                'document_version_id' => 1,
                'file_type_id' => 1
            ],
        ];
        parent::init();
    }
}
