<?php
namespace App\Model\Table;

use App\Model\Entity\Capability;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Capabilities Model
 *
 * @property \App\Model\Table\RoleTypesTable&\Cake\ORM\Association\BelongsToMany $RoleTypes
 *
 * @method Capability get($primaryKey, $options = [])
 * @method Capability newEntity($data = null, array $options = [])
 * @method Capability[] newEntities(array $data, array $options = [])
 * @method Capability|false save(EntityInterface $entity, $options = [])
 * @method Capability saveOrFail(EntityInterface $entity, $options = [])
 * @method Capability patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Capability[] patchEntities($entities, array $data, array $options = [])
 * @method Capability findOrCreate($search, callable $callback = null, $options = [])
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
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('capabilities');
        $this->setDisplayField('capability_code');
        $this->setPrimaryKey('id');

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
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('capability_code')
            ->maxLength('capability_code', 10)
            ->requirePresence('capability_code', 'create')
            ->notEmptyString('capability_code')
            ->add('capability_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('capability')
            ->maxLength('capability', 255)
            ->requirePresence('capability', 'create')
            ->notEmptyString('capability')
            ->add('capability', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('min_level')
            ->requirePresence('min_level', 'create')
            ->notEmptyString('min_level');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['capability_code']));
        $rules->add($rules->isUnique(['capability']));

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

        return $total;
    }
}
