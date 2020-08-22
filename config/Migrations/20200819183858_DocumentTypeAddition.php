<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class DocumentTypeAddition extends AbstractMigration
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
            ->table('document_types')
            ->addColumn('special_capability', 'string', [
                'limit' => 64,
                'null' => true,
            ])
            ->update();
    }
}
