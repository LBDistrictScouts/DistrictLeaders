<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\CapabilitiesRoleType;
use App\Model\Entity\Capability;
use App\Model\Entity\Role;
use App\Model\Entity\RoleType;
use App\Model\Entity\User;
use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RoleTypes Model
 *
 * @property \App\Model\Table\SectionTypesTable&\Cake\ORM\Association\BelongsTo $SectionTypes
 * @property \App\Model\Table\RoleTemplatesTable&\Cake\ORM\Association\BelongsTo $RoleTemplates
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\HasMany $Roles
 * @property \App\Model\Table\CapabilitiesTable&\Cake\ORM\Association\BelongsToMany $Capabilities
 * @method \App\Model\Entity\RoleType get($primaryKey, $options = [])
 * @method \App\Model\Entity\RoleType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RoleType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RoleType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoleType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoleType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RoleType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RoleType findOrCreate($search, callable $callback = null, $options = [])
 * @property \App\Model\Table\CapabilitiesRoleTypesTable&\Cake\ORM\Association\HasMany $CapabilitiesRoleTypes
 * @method \App\Model\Entity\RoleType[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 */
class RoleTypesTable extends Table
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

        $this->setTable('role_types');
        $this->setDisplayField(RoleType::FIELD_ROLE_ABBREVIATION);
        $this->setPrimaryKey(RoleType::FIELD_ID);

        $this->belongsTo('SectionTypes', [
            'foreignKey' => RoleType::FIELD_SECTION_TYPE_ID,
        ]);
        $this->belongsTo('RoleTemplates', [
            'foreignKey' => RoleType::FIELD_ROLE_TEMPLATE_ID,
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => Role::FIELD_ROLE_TYPE_ID,
        ]);
        $this->belongsToMany('Capabilities', [
            'foreignKey' => CapabilitiesRoleType::FIELD_ROLE_TYPE_ID,
            'targetForeignKey' => CapabilitiesRoleType::FIELD_CAPABILITY_ID,
            'through' => 'CapabilitiesRoleTypes',
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
            ->integer(RoleType::FIELD_ID)
            ->allowEmptyString(RoleType::FIELD_ID);

        $validator
            ->scalar(RoleType::FIELD_ROLE_TYPE)
            ->maxLength(RoleType::FIELD_ROLE_TYPE, 255)
            ->requirePresence(RoleType::FIELD_ROLE_TYPE, 'create')
            ->notEmptyString(RoleType::FIELD_ROLE_TYPE);

        $validator
            ->scalar(RoleType::FIELD_ROLE_ABBREVIATION)
            ->maxLength(RoleType::FIELD_ROLE_ABBREVIATION, 32)
            ->allowEmptyString(RoleType::FIELD_ROLE_ABBREVIATION);

        $validator
            ->integer(RoleType::FIELD_LEVEL)
            ->requirePresence(RoleType::FIELD_LEVEL, 'create')
            ->notEmptyString(RoleType::FIELD_LEVEL);

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
        $rules->add($rules->existsIn([RoleType::FIELD_SECTION_TYPE_ID], 'SectionTypes'));
        $rules->add($rules->existsIn([RoleType::FIELD_ROLE_TEMPLATE_ID], 'RoleTemplates'));
        $rules->add($rules->isUnique([RoleType::FIELD_ROLE_TYPE]));
        $rules->add($rules->isUnique([RoleType::FIELD_ROLE_ABBREVIATION]));

        return $rules;
    }

    /**
     * @param \App\Model\Entity\RoleType $roleType The Entity to be Patched.
     * @return \App\Model\Entity\RoleType
     */
    public function patchTemplateCapabilities($roleType)
    {
        $this->Capabilities->installBaseCapabilities();

        $templateId = $roleType->get(RoleType::FIELD_ROLE_TEMPLATE_ID);
        $template = $this->RoleTemplates->get($templateId);

        $baseCapabilities = Configure::readOrFail('allCapabilities');
        $capabilities = $baseCapabilities;
        if (!empty($template->template_capabilities)) {
            $capabilities = array_merge($capabilities, $template->template_capabilities);
        }

        foreach ($capabilities as $capability) {
            $roleCapability = $this->Capabilities
                ->find()
                ->where([Capability::FIELD_CAPABILITY_CODE => $capability])
                ->first();
            $roleCapability->_joinData = new CapabilitiesRoleType(
                [CapabilitiesRoleType::FIELD_TEMPLATE => true],
                ['markNew' => true]
            );
            $this->Capabilities->link($roleType, [$roleCapability]);
        }

        return $roleType;
    }

    /**
     * @param \App\Model\Entity\RoleType $roleType The RoleType Entity
     * @return int
     */
    public function patchRoleUsers($roleType)
    {
        $count = 0;

        $roleTypeId = $roleType->get(RoleType::FIELD_ID);
        $query = $this->Roles->Users
            ->find()
            ->matching('Roles', function (Query $q) use ($roleTypeId) {
                return $q->where(['Roles.' . Role::FIELD_ROLE_TYPE_ID => $roleTypeId]);
            });

        foreach ($query as $user) {
            $result = $this->Roles->Users->patchCapabilities($user);

            if ($result instanceof User) {
                $count += 1;
            }
        }

        return $count;
    }
}
