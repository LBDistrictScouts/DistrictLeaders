<?php
use Migrations\AbstractMigration;

class LevelMove extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
    	$this
		    ->table('role_types')
		    ->addColumn('level', 'integer', [
		    	'default' => 1,
			    'null' => false,
		    ])
		    ->save();

    	$this
	        ->table('capabilities')
		    ->renameColumn('level', 'min_level')
		    ->save();
    }

	/**
	 * Up Method.
	 *
	 * More information on this method is available here:
	 * http://docs.phinx.org/en/latest/migrations.html#the-change-method
	 * @return void
	 */
	public function down()
	{
		$this
			->table('capabilities')
			->renameColumn('min_level', 'level')
			->save();

		$this
			->table('role_types')
			->removeColumn('level')
			->save();
    }
}
