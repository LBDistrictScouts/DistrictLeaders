<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class UserStatesOrderAndSignature extends AbstractMigration
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
            ->table('user_states')
            ->addColumn('precedence_order', 'integer', [
                'null' => true,
            ])
            ->addIndex('precedence_order', ['unique' => true])
            ->addColumn('signature', 'integer', [
                'null' => false,
                'default' => 0,
            ])
            ->update();
    }
}
