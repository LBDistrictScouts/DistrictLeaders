<?php

use Migrations\AbstractMigration;

class Tokens extends AbstractMigration
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
        $table = $this->table('tokens');

        $table
            ->addColumn('token', 'string', [
                'default' => null,
                'limit' => 511,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('expires', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('utilised', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('active', 'boolean', [
                'default' => true,
                'null' => false,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('hash', 'string', [
                'default' => null,
                'limit' => 511,
                'null' => true,
            ])
            ->addColumn('random_number', 'integer', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('header', 'json', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex('user_id')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [ 'delete' => 'RESTRICT', 'update' => 'CASCADE' ]
            )
            ->create();

        $table = $this->table('password_states');

        $table
            ->addColumn('password_state', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('active', 'boolean', [
              'default' => true,
              'null' => false,
            ])
            ->addColumn('expired', 'boolean', [
              'default' => true,
              'null' => false,
            ])
            ->create();

        $table = $this->table('users');

        $table
            ->addColumn('password_state_id', 'integer', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex('password_state_id')
            ->addForeignKey(
                'password_state_id',
                'password_states',
                'id',
                [ 'delete' => 'RESTRICT', 'update' => 'CASCADE']
            )
            ->save();
    }
}
