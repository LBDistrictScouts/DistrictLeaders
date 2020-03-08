<?php

use Migrations\AbstractMigration;

class DocumentPreview extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this
            ->table('documents')
            ->addColumn('document_preview_id', 'integer', [
                'null' => true,
                'default' => null,
            ])
            ->addColumn('latest_version', 'integer', [
                'null' => true,
                'default' => null,
            ])
            ->update();
    }
}
