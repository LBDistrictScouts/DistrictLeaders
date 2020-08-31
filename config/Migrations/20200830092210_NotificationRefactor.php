<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/**
 * Class NotificationRefactor
 */
class NotificationRefactor extends AbstractMigration
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
            ->removeColumn('new')
            ->addColumn('body_content', 'json', [
                'null' => false,
                'default' => '{}',
            ])
            ->removeColumn('text')
            ->addColumn('subject_link', 'json', [
                'null' => true,
            ])
            ->removeColumn('link_id')
            ->removeColumn('link_controller')
            ->removeColumn('link_prefix')
            ->removeColumn('link_action')
            ->update();

        $this
            ->table('notification_types')
            ->addColumn('content_template', 'string', [
                'limit' => 32,
                'null' => false,
                'default' => 'standard',
            ])
            ->update();
    }
}
