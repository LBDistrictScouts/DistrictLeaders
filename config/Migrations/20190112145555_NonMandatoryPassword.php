<?php

use Migrations\AbstractMigration;

class NonMandatoryPassword extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * @return void
     */
    public function change()
    {
        $this
            ->table('users')
            ->changeColumn('password', 'string', [
                'null' => true,
                'length' => 255,
            ])
            ->changeColumn('username', 'string', [
                'null' => true,
                'length' => 255,
            ])
            ->update();
    }
}
