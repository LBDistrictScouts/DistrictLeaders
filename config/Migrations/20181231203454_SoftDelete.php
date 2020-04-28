<?php

use Migrations\AbstractMigration;

class SoftDelete extends AbstractMigration
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
            ->addColumn('deleted', 'datetime', [
                'null' => true,
            ])
            ->save();

        $this
            ->table('scout_groups')
            ->addColumn('deleted', 'datetime', [
                'null' => true,
            ])
            ->save();

        $this
            ->table('sections')
            ->addColumn('deleted', 'datetime', [
                'null' => true,
            ])
            ->save();

        $this
            ->table('roles')
            ->addColumn('deleted', 'datetime', [
                'null' => true,
            ])
            ->save();
    }
}
