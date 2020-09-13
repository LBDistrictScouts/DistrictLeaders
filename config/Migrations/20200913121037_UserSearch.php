<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class UserSearch extends AbstractMigration
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
            ->table('users')
            ->addColumn('search_string', 'text', [
                'null' => true,
            ])
            ->addColumn('tag_count', 'integer', [
                'null' => false,
                'default' => 0,
            ])
            ->update();
    }
}
