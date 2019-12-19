<?php
namespace App\Model\Table;

use App\Model\Entity\RoleTemplate;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RoleTemplates Model
 *
 * @property \App\Model\Table\RoleTypesTable&\Cake\ORM\Association\HasMany $RoleTypes
 *
 * @method RoleTemplate get($primaryKey, $options = [])
 * @method RoleTemplate newEntity($data = null, array $options = [])
 * @method RoleTemplate[] newEntities(array $data, array $options = [])
 * @method RoleTemplate|false save(EntityInterface $entity, $options = [])
 * @method RoleTemplate saveOrFail(EntityInterface $entity, $options = [])
 * @method RoleTemplate patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method RoleTemplate[] patchEntities($entities, array $data, array $options = [])
 * @method RoleTemplate findOrCreate($search, callable $callback = null, $options = [])
 */
class RoleTemplatesTable extends Table
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

        $this->setTable('role_templates');
        $this->setDisplayField(RoleTemplate::FIELD_ROLE_TEMPLATE);
        $this->setPrimaryKey(RoleTemplate::FIELD_ID);

        $this->hasMany('RoleTypes', [
            'foreignKey' => 'role_template_id'
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
            ->integer(RoleTemplate::FIELD_ID)
            ->allowEmptyString(RoleTemplate::FIELD_ID, null, 'create');

        $validator
            ->scalar(RoleTemplate::FIELD_ROLE_TEMPLATE)
            ->maxLength(RoleTemplate::FIELD_ROLE_TEMPLATE, 63)
            ->requirePresence(RoleTemplate::FIELD_ROLE_TEMPLATE, 'create')
            ->notEmptyString(RoleTemplate::FIELD_ROLE_TEMPLATE);

        $validator
            ->requirePresence(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, 'create')
            ->isArray(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES)
            ->allowEmptyArray(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES);

        $validator
            ->integer(RoleTemplate::FIELD_INDICATIVE_LEVEL)
            ->requirePresence(RoleTemplate::FIELD_INDICATIVE_LEVEL, 'create')
            ->notEmptyString(RoleTemplate::FIELD_INDICATIVE_LEVEL);

        return $validator;
    }
}