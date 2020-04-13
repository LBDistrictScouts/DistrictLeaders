<?php

use Migrations\AbstractMigration;

class UserCore extends AbstractMigration
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
        $table = $this->table('scout_groups');

        $table
            ->addColumn('scout_group', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('group_alias', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('number_stripped', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('charity_number', 'integer', [
                'default' => null,
                'null' => true,

            ])
            ->addColumn('group_domain', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addTimestamps('created', 'modified')
            ->addIndex(
                ['scout_group'],
                ['unique' => true]
            )
            ->save();

        $table = $this->table('section_types');

        $table
            ->addColumn('section_type', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addIndex(
                ['section_type'],
                ['unique' => true]
            )
            ->save();

        $table = $this->table('sections');

        $table
            ->addColumn('section', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('section_type_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('scout_group_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addTimestamps('created', 'modified')
            ->addIndex(
                ['section'],
                ['unique' => true]
            )
            ->addForeignKey('scout_group_id', 'scout_groups', ['id'])
            ->addForeignKey('section_type_id', 'section_types', ['id'])
            ->save();

        $table = $this->table('role_types');

        $table
            ->addColumn('role_type', 'string', [
                'default' => null,
                'limit' => '255',
                'null' => false,
            ])
            ->addColumn('role_abbreviation', 'string', [
                'default' => null,
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('section_type_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->save();

        $table = $this->table('role_statuses');

        $table
            ->addColumn('role_status', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addIndex(
                ['role_status'],
                ['unique' => true]
            )
            ->save();

        $table = $this->table('users');

        $table
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('membership_number', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('first_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('address_line_1', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('address_line_2', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('city', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('county', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('postcode', 'string', [
                'default' => null,
                'limit' => 9,
                'null' => true,
            ])
            ->addColumn('admin_scout_group_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addForeignKey(
                'admin_scout_group_id',
                'scout_groups',
                ['id']
            )
            ->addTimestamps('created', 'modified')
            ->addColumn('last_login', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex(
                ['username'],
                ['unique' => true]
            )
            ->addIndex(
                ['email'],
                ['unique' => true]
            )
            ->addIndex(
                ['membership_number'],
                ['unique' => true]
            )
            ->save();

        $table = $this->table('audits');

        $table
            ->addColumn('audit_field', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('audit_table', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('original_value', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('modified_value', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addForeignKey('user_id', 'users', ['id'])
            ->addColumn('change_date', 'datetime')
            ->save();

        $table = $this->table('roles');

        $table
            ->addColumn('role_type_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addForeignKey('role_type_id', 'role_types', ['id'])
            ->addColumn('section_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addForeignKey('section_id', 'sections', ['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addForeignKey('user_id', 'users', ['id'])
            ->addColumn('role_status_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addForeignKey('role_status_id', 'role_statuses', ['id'])
            ->addIndex(['role_type_id'])
            ->addIndex(['section_id'])
            ->addIndex(['user_id'])
            ->addIndex(['role_status_id'])
            ->addTimestamps('created', 'modified')
            ->save();
    }
}
