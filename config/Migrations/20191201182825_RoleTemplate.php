<?php

use Migrations\AbstractMigration;

/**
 * Class RoleTemplate
 */
class RoleTemplate extends AbstractMigration
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
            ->table('role_templates')
            ->addColumn('role_template', 'string', [
                'limit' => 63,
                'null' => false,
            ])
            ->addColumn('template_capabilities', 'json')
            ->addColumn('indicative_level', 'integer', [
                'null' => false,
            ])
            ->save();

        $this
            ->table('role_types')
            ->addColumn('role_template_id', 'integer', [
                'null' => true,
            ])
            ->addForeignKey('role_template_id', 'role_templates', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'SET_NULL',
            ])
            ->save();
    }
}
