<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\Utility\Inflector;

/**
 * Trait BaseInstallerTrait
 *
 * @package App\Model\Table
 */
trait BaseInstallerTrait
{
    /**
     * @param \Cake\ORM\Table $table The Table being Called
     * @return array
     */
    public function getBaseValues(Table $table)
    {
        $tableName = $table->getRegistryAlias();
        $fileName = Inflector::underscore($tableName);

        Configure::load('Application' . DS . $fileName, 'yaml', false);

        return Configure::readOrFail($tableName);
    }

    /**
     * install the application status config
     *
     * @param \Cake\ORM\Table $table The Table being Called
     * @param string $businessKey The Business Key of the Table
     * @return int
     */
    public function installBase(Table $table, ?string $businessKey = null): int
    {
        if (is_null($businessKey)) {
            $businessKey = $table->getDisplayField();
        }

        $base = $this->getBaseValues($table);

        $total = 0;

        foreach ($base as $baseType) {
            $query = $this->find()
                ->where([$businessKey => $baseType[$businessKey]]);
            $installedEntity = $this->newEmptyEntity();
            if ($query->count() > 0) {
                $installedEntity = $query->first();
            }
            $this->patchEntity($installedEntity, $baseType);
            if ($this->save($installedEntity)) {
                $total += 1;
            }
        }

        return $total;
    }
}
