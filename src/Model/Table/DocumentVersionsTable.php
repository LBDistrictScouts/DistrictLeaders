<?php
namespace App\Model\Table;

use App\Model\Entity\DocumentVersion;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentVersions Model
 *
 * @property \App\Model\Table\DocumentsTable&\Cake\ORM\Association\BelongsTo $Documents
 * @property \App\Model\Table\DocumentEditionsTable&\Cake\ORM\Association\HasMany $DocumentEditions
 *
 * @method DocumentVersion get($primaryKey, $options = [])
 * @method DocumentVersion newEntity($data = null, array $options = [])
 * @method DocumentVersion[] newEntities(array $data, array $options = [])
 * @method DocumentVersion|false save(EntityInterface $entity, $options = [])
 * @method DocumentVersion saveOrFail(EntityInterface $entity, $options = [])
 * @method DocumentVersion patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method DocumentVersion[] patchEntities($entities, array $data, array $options = [])
 * @method DocumentVersion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DocumentVersionsTable extends Table
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

        $this->setTable('document_versions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Documents', [
            'foreignKey' => 'document_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('DocumentEditions', [
            'foreignKey' => 'document_version_id',
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
            ->integer('version_number')
            ->requirePresence('version_number', 'create')
            ->notEmptyString('version_number');

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
        $rules->add($rules->existsIn(['document_id'], 'Documents'));

        $rules->add($rules->isUnique(['version_number', 'document_id']));

        return $rules;
    }
}
