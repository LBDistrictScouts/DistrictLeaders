<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Capability;
use Cake\Core\Configure;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;

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
     * @return int
     */
    public function generateEntityCapabilities()
    {
        $count = 0;
        foreach (Configure::read('allModels') as $model => $options) {
            $model = Inflector::camelize($model);
            $count += $this->entityCapability($model, $options['baseLevel'], $options['viewRestricted']);
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
            $code = $this->capabilityCodeFormat($action, $entity);
            $data[Capability::FIELD_CAPABILITY_CODE] = $code;

            $data[Capability::FIELD_MIN_LEVEL] = $this->calculateLevel($baseLevel, $multiplier, $viewRestricted);
            $data[Capability::FIELD_CAPABILITY] = $this->capabilityNameFormat($code);

            $capability = $this->findOrCreate($data);
            if ($capability instanceof \App\Model\Entity\Capability) {
                $count += 1;
            }
        }

        return $count;
    }

    /**
     * @param string $action The name of the Action performed
     * @param string $capability The Capability to be formatted
     *
     * @return string
     */
    protected function capabilityCodeFormat($action, $capability)
    {
        $code = ucfirst(strtolower($action)) . $capability;
        $code = Inflector::underscore(Inflector::singularize($code));

        return strtoupper($code);
    }

    /**
     * @param string $capabilityCode The Capability Code to be formatted.
     *
     * @return string
     */
    protected function capabilityNameFormat($capabilityCode)
    {
        return ucwords(strtolower(Inflector::humanize($capabilityCode)));
    }

    /**
     * @param int $baseLevel The Base Level for Capability
     * @param int $multiplier The Action Multiplier
     * @param bool $viewRestricted Is the view action restricted
     *
     * @return int
     */
    protected function calculateLevel($baseLevel, $multiplier, $viewRestricted)
    {
        if ($multiplier == -5 && $viewRestricted) {
            $multiplier = 0;
        }
        $level = $baseLevel + $multiplier;

        $minLevel = 1;
        if ($baseLevel == 0) {
            $minLevel = 0;
        }
        $level = max($minLevel, $level);

        return min(5, $level);
    }
}
