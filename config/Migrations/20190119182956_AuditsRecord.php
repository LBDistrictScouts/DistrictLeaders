<?php

use Migrations\AbstractMigration;

class AuditsRecord extends AbstractMigration
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
            ->table('audits')
            ->addColumn('audit_record_id', 'integer')
            ->update();
    }
}
