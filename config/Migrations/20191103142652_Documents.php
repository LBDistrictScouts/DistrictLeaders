<?php
use Migrations\AbstractMigration;

class Documents extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this
            ->table('document_types')
            ->addColumn('document_type', 'string', [
                'limit' => 31,
                'null' => false,
                'default' => 'null',
            ])
            ->addIndex('document_type', ['unique' => true])
            ->save();

        $this
            ->table('file_types')
            ->addColumn('file_type', 'string', [
                'limit' => 31,
                'null' => false,
            ])
            ->addIndex('file_type', ['unique' => true])
            ->addColumn('file_extension', 'string', [
                'limit' => 10,
                'null' => false,
                'default' => 'null',
            ])
            ->addIndex('file_extension', ['unique' => true])
            ->save();

        $this
            ->table('documents')
            ->addColumn('document_type_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('document_type_id', 'document_types', ['id'], [
                'delete' => 'RESTRICT',
                'update' => 'RESTRICT',
            ])
            ->addTimestamps('created', 'modified', true)
            ->addColumn('deleted', 'datetime', [
                'null' => true,
            ])
            ->addColumn('document', 'string', [
                'limit' => 255,
                'null' => false,
                'default' => 'null',
            ])
            ->addIndex('document', ['unique' => true])
            ->save();

        $this
            ->table('document_versions')
            ->addColumn('document_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('document_id', 'documents', ['id'], [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addTimestamps('created', 'modified', true)
            ->addColumn('deleted', 'datetime', [
                'null' => true,
            ])
            ->addColumn('version_number', 'integer', [
                'null' => false,
            ])
            ->addIndex(['version_number', 'document_id'], ['unique' => true])
            ->save();

        $this
            ->table('document_editions')
            ->addTimestamps('created', 'modified', true)
            ->addColumn('deleted', 'datetime', [
                'null' => true,
            ])
            ->addColumn('document_version_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('document_version_id', 'document_versions', ['id'], [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addColumn('file_type_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('file_type_id', 'file_types', ['id'], [
                'delete' => 'RESTRICT',
                'update' => 'RESTRICT',
            ])
            ->addIndex(['file_type_id', 'document_version_id'], ['unique' => true])
            ->save();
    }
}
