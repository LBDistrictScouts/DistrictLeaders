<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/**
 * Class SectionAdditions
 */
class SectionAdditions extends AbstractMigration
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
        $this->table('scout_groups')
            ->addColumn('public', 'boolean', [
                'null' => false,
                'default' => true,
            ])
            ->save();

        $this->table('sections')
            ->addColumn('public', 'boolean', [
                'null' => false,
                'default' => true,
            ])
            ->addColumn('meeting_day', 'integer', [
                'null' => true,
            ])
            ->addColumn('meeting_start_time', 'string', [
                'null' => true,
                'limit' => 5,
            ])
            ->addColumn('meeting_end_time', 'string', [
                'null' => true,
                'limit' => 5,
            ])
            ->save();
    }
}
