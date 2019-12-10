<?php
use Migrations\AbstractMigration;

class FilePath extends AbstractMigration
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
            ->table('document_editions')
            ->addColumn('file_path', 'string', [
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('filename', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('size', 'integer', [
                'null' => true,
            ])
            ->addColumn('md5_hash', 'string', [
                'limit' => 32,
                'null' => true,
            ])
            ->save();

        $this
            ->table('file_types')
            ->addColumn('mime', 'string', [
                'limit' => 32,
                'null' => true,
            ])
            ->save();
    }
}
