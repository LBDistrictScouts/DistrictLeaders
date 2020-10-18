<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/**
 * Class ReaddNewToNotifications
 */
class ReturnNewToNotifications extends AbstractMigration
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
            ->table('notifications')
            ->addColumn('new', 'boolean', [
                'default' => true,
                'null' => false,
            ])
            ->update();
    }
}
