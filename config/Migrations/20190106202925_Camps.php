<?php

use Migrations\AbstractMigration;

class Camps extends AbstractMigration
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
            ->table('camp_types')
            ->addColumn('camp_type', 'string', [
                'length' => 30,
                'null' => false,
            ])
            ->addIndex('camp_type', [
                'unique' => true,
            ])
            ->create();

        $this
            ->table('camps')
            ->addTimestamps('created', 'modified')
            ->addColumn('deleted', 'datetime', [
                'null' => true,
            ])
            ->addColumn('camp_name', 'string', [
                'length' => 255,
                'null' => false,
            ])
            ->addColumn('camp_type_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('camp_type_id', 'camp_types', ['id'])
            ->addColumn('camp_start', 'datetime', [
                'null' => false,
            ])
            ->addColumn('camp_end', 'datetime', [
                'null' => false,
            ])
            ->create();

        $this
            ->table('camp_role_types')
            ->addTimestamps('created', 'modified')
            ->addColumn('camp_role_type', 'string', [
                'limit' => 30,
                'null' => false,
            ])
            ->addIndex('camp_role_type', [
                'unique' => true,
            ])
            ->create();

        $this
            ->table('camp_roles')
            ->addTimestamps('created', 'modified')
            ->addColumn('camp_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('camp_id', 'camps', ['id'], [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addColumn('user_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('user_id', 'users', ['id'], [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addColumn('camp_role_type_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('camp_role_type_id', 'camp_role_types', ['id'], [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();
    }
}
