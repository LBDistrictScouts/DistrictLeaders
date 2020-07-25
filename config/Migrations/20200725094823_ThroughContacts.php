<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ThroughContacts extends AbstractMigration
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
        $this->table('user_contacts')
            ->addColumn('directory_user_id', 'integer', [
                'null' => true,
            ])
            ->addForeignKey('directory_user_id', 'directory_users', ['id'], [
                'delete' => 'SET_NULL',
                'update' => 'NO_ACTION',
            ])
            ->update();
    }
}
