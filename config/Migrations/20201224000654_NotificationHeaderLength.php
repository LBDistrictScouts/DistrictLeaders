<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class NotificationHeaderLength extends AbstractMigration
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
            ->changeColumn('notification_header', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->update();
    }
}
