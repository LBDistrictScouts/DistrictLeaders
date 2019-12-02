<?php
namespace App\Model\Table;

use App\Model\Entity\Document;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Documents Model
 *
 * @property \App\Model\Table\DocumentTypesTable&\Cake\ORM\Association\BelongsTo $DocumentTypes
 * @property \App\Model\Table\DocumentVersionsTable&\Cake\ORM\Association\HasMany $DocumentVersions
 *
 * @method Document get($primaryKey, $options = [])
 * @method Document newEntity($data = null, array $options = [])
 * @method Document[] newEntities(array $data, array $options = [])
 * @method Document|false save(EntityInterface $entity, $options = [])
 * @method Document saveOrFail(EntityInterface $entity, $options = [])
 * @method Document patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Document[] patchEntities($entities, array $data, array $options = [])
 * @method Document findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @mixin \App\Model\Behavior\CaseableBehavior
 */
class DocumentsTable extends Table
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

        $this->setTable('documents');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->addBehavior('Caseable', [
            'case_columns' => [
                Document::FIELD_DOCUMENT => 't',
            ]
        ]);

        $this->belongsTo('DocumentTypes', [
            'foreignKey' => 'document_type_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('DocumentVersions', [
            'foreignKey' => 'document_id'
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
            ->integer(Document::FIELD_ID)
            ->allowEmptyString(Document::FIELD_ID, null, 'create');

        $validator
            ->scalar(Document::FIELD_DOCUMENT)
            ->maxLength(Document::FIELD_DOCUMENT, 255)
            ->notEmptyString(Document::FIELD_DOCUMENT)
            ->add(Document::FIELD_DOCUMENT, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['document']));
        $rules->add($rules->existsIn(['document_type_id'], 'DocumentTypes'));

        return $rules;
    }
}
