<?php

use Migrations\AbstractMigration;

class UserContacts extends AbstractMigration
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
            ->table('user_contact_types')
            ->addColumn('user_contact_type', 'string', [
                'null' => false,
                'limit' => 32,
            ])
            ->addTimestamps('created', 'modified')
            ->save();

        $this
            ->table('user_contacts')
            ->addColumn('contact_field', 'string', [
                'null' => false,
                'limit' => 64,
            ])
            ->addColumn('user_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('user_id', 'users', ['id'], [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addColumn('user_contact_type_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('user_contact_type_id', 'user_contacts', ['id'], [
                'delete' => 'RESTRICT',
                'update' => 'RESTRICT',
            ])
            ->addTimestamps('created', 'modified')
            ->addColumn('verified', 'boolean', [
                'default' => false,
                'null' => false,
            ])
            ->addColumn('deleted', 'timestamp', [
                'null' => true,
            ])
            ->save();

        $this
            ->table('roles')
            ->addColumn('user_contact_id', 'integer', [
                'null' => true,
            ])
            ->addForeignKey('user_contact_id', 'user_contacts', ['id'], [
                'delete' => 'SET_NULL',
                'update' => 'SET_NULL',
            ])
            ->save();
    }
}
