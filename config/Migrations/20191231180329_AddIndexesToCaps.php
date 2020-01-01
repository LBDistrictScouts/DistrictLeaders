<?php
use Migrations\AbstractMigration;

class AddIndexesToCaps extends AbstractMigration
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
            ->addIndex('min_level', ['unique' => false])
            ->save();
    }
}
