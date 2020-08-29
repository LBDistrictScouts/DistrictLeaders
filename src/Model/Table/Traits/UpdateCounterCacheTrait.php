<?php
declare(strict_types=1);

namespace App\Model\Table\Traits;

/**
 * Trait UpdateCounterCacheTrait
 *
 * @package App\Model\Table\Traits
 */
trait UpdateCounterCacheTrait
{
    /**
     * @param null|string|array $association Table Association
     *        null - update all CounterCaches
     *        string - update only the CounterCache for this association
     *        array - update CounterCaches for the listed associations,
     *            update only the fields listed like ['Tags' => ['count']]
     *            if no $cacheFields given, to update all set the key to true
     * @param null|string|array $cacheField Field for Counter Cache
     *        null - update all fields for the CounterCache(s)
     *        string - update only this field for the CounterCache(s)
     *        array - update the given fields in the CounterCache(s),
     *            overwriting possible set fields from the $association array
     * @param true|false $reset reset the values to 0, if no matching entry could be found
     * @return int
     *        if $verbose_return == false, the total number of updated fields
     * @throws \App\Model\Table\Traits\BehaviourNotFoundException when the CounterCacheBehavior is not attached
     */
    public function updateCounterCache($association = null, $cacheField = null, $reset = true)
    {
        $counterCache = $this->behaviors()->get('CounterCache');

        if (!$counterCache) {
            throw new BehaviourNotFoundException('CounterCacheBehavior is not attached.');
        }

        if (is_string($association)) {
            $association = [$association => true];
        }
        if (is_string($cacheField)) {
            $cacheField = [$cacheField];
        }

        $associations = $counterCache->getConfig();
        if ($association) {
            $associations = array_intersect_key($associations, $association);
        }

        $totalCount = 0;
        foreach ($associations as $assocName => $config) {
            /** @var \Cake\ORM\Association\BelongsTo $assoc */
            $assoc = $this->{$assocName};
            $foreignKey = $assoc->getForeignKey();
            $target = $assoc->getTarget();
            $conds = $assoc->getConditions();

            if ($cacheField) {
                $config = array_intersect_key($config, array_flip($cacheField));
            } elseif (isset($association) && is_array($association[$assocName])) {
                $config = array_intersect_key($config, array_flip($association[$assocName]));
            }

            foreach ($config as $field => $options) {
                if (is_numeric($field)) {
                    $field = $options;
                    $options = [];
                }

                if ($reset) {
                    $target->query()
                        ->update()
                        ->set($field, 0)
                        ->where($conds)
                        ->execute();
                }

                if (!isset($options['conditions'])) {
                    $options['conditions'] = [];
                }

                $finder = $this->query();

                if (isset($options['finder']) && $this->hasFinder($options['finder'])) {
                    $finder = $this->callFinder($options['finder'], $finder);
                }

                /** @var \Cake\ORM\Query $result */
                $result = $finder
                    ->select([$foreignKey => $foreignKey, 'count' => $this->query()->func()->count('*')])
                    ->where($options['conditions'])
                    ->group($foreignKey)
                    ->execute();

                $totalRows = $result->count();
                $rowCount = 0;
                $count = 0;

                foreach ($result as $row) {
                    if ($rowCount++ > $totalRows / 100) {
                        $rowCount = 0;
                    }
                    $target->query()
                        ->update()
                        ->set($field, $row['count'])
                        ->where([$target->getPrimaryKey() => $row[$foreignKey]] + $conds)
                        ->execute();
                    $count++;
                }
                $totalCount += $count;
            }
        }

        return $totalCount;
    }
}
