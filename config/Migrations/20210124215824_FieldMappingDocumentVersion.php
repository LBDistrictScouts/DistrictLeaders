<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class FieldMappingDocumentVersion extends AbstractMigration
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
            ->removeColumn('phone_number')
            ->update();

        $this
            ->table('document_versions')
            ->addColumn('field_mapping', 'json', [
                'null' => true,
            ])
            ->update();
    }
}
