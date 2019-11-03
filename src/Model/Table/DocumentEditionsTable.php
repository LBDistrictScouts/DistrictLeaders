<?php
namespace App\Model\Table;

use App\Model\Entity\DocumentEdition;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentEditions Model
 *
 * @property \App\Model\Table\DocumentVersionsTable&\Cake\ORM\Association\BelongsTo $DocumentVersions
 * @property \App\Model\Table\FileTypesTable&\Cake\ORM\Association\BelongsTo $FileTypes
 *
 * @method DocumentEdition get($primaryKey, $options = [])
 * @method DocumentEdition newEntity($data = null, array $options = [])
 * @method DocumentEdition[] newEntities(array $data, array $options = [])
 * @method DocumentEdition|false save(EntityInterface $entity, $options = [])
 * @method DocumentEdition saveOrFail(EntityInterface $entity, $options = [])
 * @method DocumentEdition patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method DocumentEdition[] patchEntities($entities, array $data, array $options = [])
 * @method DocumentEdition findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DocumentEditionsTable extends Table
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

        $this->setTable('document_editions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('DocumentVersions', [
            'foreignKey' => 'document_version_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FileTypes', [
            'foreignKey' => 'file_type_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['document_version_id'], 'DocumentVersions'));
        $rules->add($rules->existsIn(['file_type_id'], 'FileTypes'));

        $rules->add($rules->isUnique(['file_type_id', 'document_version_id']));

        return $rules;
    }
}
