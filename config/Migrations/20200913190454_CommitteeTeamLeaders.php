<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CommitteeTeamLeaders extends AbstractMigration
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
            ->table('section_types')
            ->addColumn('section_type_code', 'string', [
                'limit' => 1,
                'null' => false,
                'default' => 'l',
            ])
            ->update();

        $this
            ->table('role_types')
            ->addColumn('placeholder_code', 'string', [
                'limit' => 3,
                'null' => false,
                'default' => 'LDR',
            ])
            ->addColumn('role_type_sort_order', 'integer', [
                'null' => false,
                'default' => 0,
            ])
            ->update();
    }
}
