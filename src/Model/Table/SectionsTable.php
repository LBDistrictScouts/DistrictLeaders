<?php
namespace App\Model\Table;

use App\Model\Entity\Section;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sections Model
 *
 * @property \App\Model\Table\SectionTypesTable&\Cake\ORM\Association\BelongsTo $SectionTypes
 * @property \App\Model\Table\ScoutGroupsTable&\Cake\ORM\Association\BelongsTo $ScoutGroups
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\HasMany $Roles
 *
 * @method Section get($primaryKey, $options = [])
 * @method Section newEntity($data = null, array $options = [])
 * @method Section[] newEntities(array $data, array $options = [])
 * @method Section|false save(EntityInterface $entity, $options = [])
 * @method Section saveOrFail(EntityInterface $entity, $options = [])
 * @method Section patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Section[] patchEntities($entities, array $data, array $options = [])
 * @method Section findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 */
class SectionsTable extends Table
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

        $this->setTable('sections');
        $this->setDisplayField('section');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->belongsTo('SectionTypes', [
            'foreignKey' => 'section_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ScoutGroups', [
            'foreignKey' => 'scout_group_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'section_id'
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
            ->scalar('section')
            ->maxLength('section', 255)
            ->requirePresence('section', 'create')
            ->notEmptyString('section')
            ->add('section', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['section']));
        $rules->add($rules->existsIn(['section_type_id'], 'SectionTypes'));
        $rules->add($rules->existsIn(['scout_group_id'], 'ScoutGroups'));

        return $rules;
    }
}
