<?php

use Migrations\AbstractMigration;

class CapabilitiesLength extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * @return void
     */
    public function up()
    {
        $this
            ->table('capabilities')
            ->changeColumn('capability_code', 'string', [
                'null' => false,
                'length' => 63,
            ])
            ->save();
    }

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * @return void
     */
    public function down()
    {
        $this
            ->table('capabilities')
            ->changeColumn('capability_code', 'string', [
                'null' => false,
                'length' => 10,
            ])
            ->save();
    }
}
