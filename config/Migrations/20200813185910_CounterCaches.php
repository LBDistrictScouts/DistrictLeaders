<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CounterCaches extends AbstractMigration
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
            ->table('users')
            ->addColumn('all_role_count', 'integer', [
                'null' => true,
            ])
            ->addColumn('active_role_count', 'integer', [
                'null' => true,
            ])
            ->addColumn('all_email_count', 'integer', [
                'null' => true,
            ])
            ->addColumn('all_phone_count', 'integer', [
                'null' => true,
            ])
            ->addColumn('receive_emails', 'boolean', [
                'default' => true,
                'null' => false,
            ])
            ->addColumn('validated_email_count', 'integer', [
                'null' => true,
            ])
            ->addColumn('validated_phone_count', 'integer', [
                'null' => true,
            ])
            ->update();

        $this
            ->table('role_types')
            ->addColumn('all_role_count', 'integer', [
                'null' => true,
            ])
            ->addColumn('active_role_count', 'integer', [
                'null' => true,
            ])
            ->update();
    }
}
