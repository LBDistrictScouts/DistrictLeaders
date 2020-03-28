<?php

use Migrations\AbstractMigration;

class UserStatus extends AbstractMigration
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
            ->table('password_states')
            ->rename('user_states')
            ->renameColumn('password_state', 'user_state')
            ->update();

        $this->table('users')
            ->renameColumn('password_state_id', 'user_state_id')
            ->update();
    }
}
