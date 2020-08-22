<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Md5HashUpdate extends AbstractMigration
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
            ->changeColumn('md5_hash', 'string', [
                'limit' => 40,
                'null' => true,
            ])
            ->update();
    }
}
