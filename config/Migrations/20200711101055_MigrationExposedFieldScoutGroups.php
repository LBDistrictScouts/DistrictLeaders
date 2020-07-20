<?php

use Migrations\AbstractMigration;

class MigrationExposedFieldScoutGroups extends AbstractMigration
{
    /**
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('scout_groups');
        $table->addColumn('uuid', 'uuid', [
            'default' => null,
            'null' => true, // Add it as true for existing entities first, then fill/populate, then set to false afterwards.

        ]);
        $table->addIndex(['uuid'], ['unique' => true]);
        $table->update();
    }
}
