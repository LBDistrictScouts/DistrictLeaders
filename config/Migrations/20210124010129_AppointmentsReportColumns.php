<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AppointmentsReportColumns extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change()
    {
        $this
            ->table('compass_records')
            ->addColumn('preferred_forename', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('start_date', 'string', [
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('role_status', 'string', [
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('line_manager_number', 'integer', [
                'null' => true,
            ])
            ->addColumn('district', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('scout_group', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('scout_group_section', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('phone_number', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->update();
    }
}
