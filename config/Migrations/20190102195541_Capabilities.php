<?php
use Migrations\AbstractMigration;

class Capabilities extends AbstractMigration
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
		    ->table('capabilities')
		    ->addColumn('capability_code', 'string', [
		    	'null' => false,
			    'length' => 10,
		    ])
		    ->addIndex('capability_code', [
		    	'unique' => true,
		    ])
		    ->addColumn('capability', 'string', [
		    	'null' => false,
			    'length' => 255,
		    ])
		    ->addIndex('capability', [
		    	'unique' => true,
		    ])
		    ->addColumn('level', 'integer', [
		    	'null' => false,
			    'default' => 1,
		    ])
		    ->create();

    	$this
		    ->table('capabilities_role_types', ['id' => false, 'primary_key' => ['capability_id', 'role_type_id']])
		    ->addColumn('capability_id', 'integer', [
		    	'null' => false,
		    ])
		    ->addForeignKey(
		    	'capability_id',
			    'capabilities',
			    ['id'],
			    [
			    	'delete' => 'CASCADE',
				    'update' => 'CASCADE',
			    ])
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
