<?php
use Migrations\AbstractMigration;

class Sessions extends AbstractMigration
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
		    ->table('site_sessions', [ 'id' => false, 'primary_key' => 'id'])
		    ->addColumn('id', 'string', [
		    	'length' => 40,
			    'null' => false,
		    ])
		    ->addTimestamps('created', 'modified')
		    ->addColumn('data', 'text')
		    ->addColumn('expires', 'integer')
		    ->create();
    }
}
