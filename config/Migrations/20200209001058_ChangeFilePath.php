<?php

use Migrations\AbstractMigration;

class ChangeFilePath extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change()
    {
        $this
            ->table('document_editions')
            ->changeColumn('file_path', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->save();
    }
}
