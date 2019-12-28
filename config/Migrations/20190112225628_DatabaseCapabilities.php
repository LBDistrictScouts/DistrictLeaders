<?php

use Migrations\AbstractMigration;

class DatabaseCapabilities extends AbstractMigration
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
            ->removeColumn('admin_scout_group_id')
            ->addColumn('capabilities', 'json', [
                'null' => true,
            ])
            ->update();
    }
}
