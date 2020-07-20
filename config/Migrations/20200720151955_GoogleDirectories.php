<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class GoogleDirectories extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->table('directory_types')
            ->addColumn('directory_type', 'string', [
                'limit' => 64,
                'null' => false,
            ])
            ->addIndex('directory_type', ['unique' => true])
            ->addColumn('directory_type_code', 'string', [
                'limit' => 64,
                'null' => false,
            ])
            ->addIndex('directory_type_code', ['unique' => true])
            ->save();

        $this->table('directories')
            ->addColumn('directory', 'string', [
                'limit' => 64,
                'null' => false,
            ])
            ->addIndex(['directory'], ['unique' => true])
            ->addColumn('configuration_payload', 'json', [
                'null' => true,
            ])
            ->addColumn('directory_type_id', 'integer', [
                'null' => false,
                'default' => 1,
            ])
            ->addForeignKey('directory_type_id', 'directory_types')
            ->addColumn('active', 'boolean', [
                'null' => false,
                'default' => true,
            ])
            ->addColumn('customer_reference', 'string', [
                'limit' => 12,
                'null' => true,
            ])
            ->addIndex('customer_reference', ['unique' => true])
            ->save();

        $this->table('directory_domains')
            ->addColumn('directory_domain', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addIndex('directory_domain', ['unique' => true])
            ->addColumn('directory_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('directory_id', 'directories')
            ->addColumn('ingest', 'boolean', [
                'null' => false,
                'default' => true,
            ])
            ->save();

        $this->table('directory_groups')
            ->addColumn('directory_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('directory_id', 'directories')
            ->addColumn('directory_group_name', 'string', [
                'limit' => 255,
                'null' => false
            ])
            ->addColumn('directory_group_email', 'string', [
                'limit' => 100,
                'null' => false,
            ])
            ->addIndex('directory_group_email', ['unique' => true])

            ->addColumn('directory_group_reference', 'string', [
                'limit' => 64,
                'null' => true,
            ])
            ->addIndex('directory_group_reference', ['unique' => true])
            ->save();

        $this->table('directory_users')
            ->addColumn('directory_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey('directory_id', 'directories')
            ->addColumn('directory_user_reference', 'string', [
                'limit' => 64,
                'null' => false,
            ])
            ->addIndex('directory_user_reference', ['unique' => true])
            ->addColumn('given_name', 'string', [
                'limit' => 64,
                'null' => false,
            ])
            ->addColumn('family_name', 'string', [
                'limit' => 64,
                'null' => false,
            ])
            ->addColumn('primary_email', 'string', [
                'limit' => 64,
                'null' => false,
            ])
            ->addIndex('primary_email', ['unique' => true])
            ->save();

        $this->table('role_types_directory_groups', ['id' => false, 'primary_key' => ['directory_group_id', 'role_type_id']])
            ->addColumn('directory_group_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey(
                'directory_group_id',
                'directory_groups',
                ['id'],
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ]
            )
            ->addColumn('role_type_id', 'integer', [
                'null' => false,
            ])
            ->addForeignKey(
                'role_type_id',
                'role_types',
                ['id'],
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ]
            )
            ->create();
    }
}
