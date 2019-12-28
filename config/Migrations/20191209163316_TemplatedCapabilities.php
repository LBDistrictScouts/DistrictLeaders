<?php

use Migrations\AbstractMigration;

class TemplatedCapabilities extends AbstractMigration
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
            ->table('capabilities_role_types')
            ->addColumn('template', 'boolean', [
                'null' => false,
                'default' => false,
            ])
            ->save();
    }
}
