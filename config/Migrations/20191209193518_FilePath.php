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
            ->addColumn('md5_hash', 'string', [
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('file_path', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->save();
    }
}
