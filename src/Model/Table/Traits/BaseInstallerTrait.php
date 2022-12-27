<?php

declare(strict_types=1);

namespace App\Model\Table\Traits;

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
     * @param Table $table The Table being Called
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
     * @param Table $table The Table being Called
     * @param string|null $businessKey The Business Key of the Table
     * @param callable|null $callback The Callback Function for Additional Processing
     * @param string|null $callbackKey The Key of the Data Array for Callback
     * @return int
     */
    public function installBase(
        Table $table,
        ?string $businessKey = null,
        ?callable $callback = null,
        ?string $callbackKey = null
    ): int {
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

            if (!is_null($callbackKey) && key_exists($callbackKey, $baseType)) {
                $callbackData = $baseType[$callbackKey];
                $installedEntity = call_user_func($callback, $installedEntity, $callbackData);
                unset($baseType[$callbackKey]);
            }

            $this->patchEntity($installedEntity, $baseType);
            if ($this->save($installedEntity)) {
                $total += 1;
            }
        }

        return $total;
    }
}
