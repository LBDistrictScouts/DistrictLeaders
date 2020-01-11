<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Capability;
use App\Utility\CapBuilder;
use Cake\Core\Configure;
use Cake\Database\Exception;
use Cake\Database\Expression\QueryExpression;
use Cake\Database\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;
use Monolog\Test\TestCase;

/**
 * Capabilities Model
 *
 * @property \App\Model\Table\RoleTypesTable&\Cake\ORM\Association\BelongsToMany $RoleTypes
 *
 * @method \App\Model\Entity\Capability get($primaryKey, $options = [])
 * @method \App\Model\Entity\Capability newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Capability[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Capability|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Capability saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Capability patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Capability[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Capability findOrCreate($search, callable $callback = null, $options = [])
 * @property \App\Model\Table\CapabilitiesRoleTypesTable&\Cake\ORM\Association\HasMany $CapabilitiesRoleTypes
 */
class CapabilitiesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('capabilities');
        $this->setDisplayField(Capability::FIELD_CAPABILITY_CODE);
        $this->setPrimaryKey(Capability::FIELD_ID);

        $this->belongsToMany('RoleTypes', [
            'foreignKey' => 'capability_id',
            'targetForeignKey' => 'role_type_id',
            'joinTable' => 'capabilities_role_types',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer(Capability::FIELD_ID)
            ->allowEmptyString(Capability::FIELD_ID, null, 'create');

        $validator
            ->scalar(Capability::FIELD_CAPABILITY_CODE)
            ->maxLength(Capability::FIELD_CAPABILITY_CODE, 63)
            ->requirePresence(Capability::FIELD_CAPABILITY_CODE, 'create')
            ->notEmptyString(Capability::FIELD_CAPABILITY_CODE)
            ->add(Capability::FIELD_CAPABILITY_CODE, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar(Capability::FIELD_CAPABILITY)
            ->maxLength(Capability::FIELD_CAPABILITY, 255)
            ->requirePresence(Capability::FIELD_CAPABILITY, 'create')
            ->notEmptyString(Capability::FIELD_CAPABILITY)
            ->add(Capability::FIELD_CAPABILITY, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer(Capability::FIELD_MIN_LEVEL)
            ->requirePresence(Capability::FIELD_MIN_LEVEL, 'create')
            ->notEmptyString(Capability::FIELD_MIN_LEVEL);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique([Capability::FIELD_CAPABILITY_CODE]));
        $rules->add($rules->isUnique([Capability::FIELD_CAPABILITY]));

        return $rules;
    }

    /**
     * @param \Cake\Database\Query $query The Query being modified
     * @param array $options Options for the find.
     *
     * @return mixed
     */
    public function findLevel(\Cake\Database\Query $query, array $options)
    {
        if (key_exists('level', $options) && is_numeric($options['level']) && $options['level'] >= 0 && $options['level'] <= 5) {
            return $query
                ->where(['min_level <= :level'])
                ->bind(':level', $options['level'], 'integer');
        }

        return $query
            ->where([':hold =' => 0])
            ->bind(':hold', 1, 'integer');
    }

    /**
     * install the application config capabilities
     *
     * @return int
     */
    public function installBaseCapabilities()
    {
        $base = Configure::read('baseCapabilities');

        $total = 0;

        foreach ($base as $baseCapability) {
            $capability = $this->newEntity($baseCapability);
            if ($this->save($capability)) {
                $total += 1;
            }
        }

        $total += $this->generateEntityCapabilities();

        return $total;
    }

    /**
     * @param bool $fields Option to run for Fields Too
     *
     * @return int
     */
    public function generateEntityCapabilities($fields = true)
    {
        $count = 0;
        foreach (Configure::read('allModels') as $model => $options) {
            $model = Inflector::camelize($model);
            $count += $this->entityCapability($model, $options['baseLevel'], $options['viewRestricted']);

            if ($options['fieldLock'] && $fields) {
                $count += $this->fieldCapability($model, $options['fieldLock']);
            }
        }

        return $count;
    }

    /**
     * @param string $entity The Entity to be generated
     * @param int $baseLevel The Base level of the entity
     * @param bool|null $viewRestricted Is the view restricted
     *
     * @return int
     */
    public function entityCapability($entity, $baseLevel, $viewRestricted = false)
    {
        $entityActions = Configure::read('entityCapabilities');
        $count = 0;

        foreach ($entityActions as $action => $multiplier) {
            $data[Capability::FIELD_CAPABILITY_CODE] = CapBuilder::capabilityCodeFormat($action, $entity);

            $data[Capability::FIELD_MIN_LEVEL] = CapBuilder::calculateLevel($baseLevel, $multiplier, $viewRestricted);
            $data[Capability::FIELD_CAPABILITY] = CapBuilder::capabilityNameFormat($action, $entity);

            $capability = $this->makeOrPatch($data);
            if ($capability instanceof Capability) {
                $count += 1;
            }
        }

        return $count;
    }

    /**
     * @param string $entity The Entity to be generated
     * @param int $baseLevel The Base level of the entity
     *
     * @return int
     */
    public function fieldCapability($entity, $baseLevel)
    {
        $fieldActions = Configure::read('fieldCapabilities');

        $table = TableRegistry::getTableLocator()->get($entity);
        if (!($table instanceof Table)) {
            return false;
        }

        try {
            $record = $table->find()->disableHydration()->first();
            if (!is_array($record)) {
                return false;
            }
            $fields = array_keys($record);
        } catch (Exception $exception) {
            return false;
        }

        $count = 0;

        foreach ($fieldActions as $action => $multiplier) {
            foreach ($fields as $field) {
                $data[Capability::FIELD_CAPABILITY_CODE] = CapBuilder::capabilityCodeFormat($action, $entity, $field);

                $data[Capability::FIELD_MIN_LEVEL] = CapBuilder::calculateLevel($baseLevel, $multiplier);
                $data[Capability::FIELD_CAPABILITY] = CapBuilder::capabilityNameFormat($action, $entity, $field);

                $capability = $this->makeOrPatch($data);
                if ($capability instanceof Capability) {
                    $count += 1;
                }
            }
        }

        return $count;
    }

    /**
     * @param array $objectArray The array to be saved
     *
     * @return Capability|false
     */
    protected function makeOrPatch($objectArray)
    {
        if ($this->exists([Capability::FIELD_CAPABILITY_CODE => $objectArray[Capability::FIELD_CAPABILITY_CODE]])) {
            $capability = $this->find()->where([Capability::FIELD_CAPABILITY_CODE => $objectArray[Capability::FIELD_CAPABILITY_CODE]])->first();
        } else {
            $capability = $this->newEntity();
        }

        $capability = $this->patchEntity($capability, $objectArray);

        return $this->save($capability);
    }

    /**
     * @param string $action Action Method
     * @param string $model Model to be referenced
     * @param string|null $field The Field being referenced
     *
     * @return string
     */
    public function buildCapability($action, $model, $field = null)
    {
        if (!TableRegistry::getTableLocator()->exists($model)) {
            return false;
        }

        if (!CapBuilder::isActionType($action)) {
            return false;
        }

        return CapBuilder::capabilityCodeFormat($action, $model, $field);
    }
}
