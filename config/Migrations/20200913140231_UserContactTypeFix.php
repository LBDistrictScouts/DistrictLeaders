<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class UserContactTypeFix extends AbstractMigration
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
            ->table('user_contacts')
            ->dropForeignKey('user_contact_type_id')
            ->addForeignKey('user_contact_type_id', 'user_contact_types', ['id'])
            ->update();
    }
}
