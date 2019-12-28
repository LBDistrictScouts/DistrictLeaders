<?php

use Migrations\AbstractMigration;

class Authorisation extends AbstractMigration
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
            ->table('users')
            ->addColumn('last_login_ip', 'string', [
                'default' => 'null',
                'null' => true,
                'length' => 255,
            ])
            ->save();
    }
}
