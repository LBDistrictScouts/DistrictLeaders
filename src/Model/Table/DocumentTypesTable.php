<?php
namespace App\Model\Table;

use App\Model\Entity\Document;
use App\Model\Entity\DocumentType;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentTypes Model
 *
 * @property \App\Model\Table\DocumentsTable&\Cake\ORM\Association\HasMany $Documents
 *
 * @method DocumentType get($primaryKey, $options = [])
 * @method DocumentType newEntity($data = null, array $options = [])
 * @method DocumentType[] newEntities(array $data, array $options = [])
 * @method DocumentType|false save(EntityInterface $entity, $options = [])
 * @method DocumentType saveOrFail(EntityInterface $entity, $options = [])
 * @method DocumentType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method DocumentType[] patchEntities($entities, array $data, array $options = [])
 * @method DocumentType findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentTypesTable extends Table
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

        $this->setTable('document_types');
        $this->setDisplayField(DocumentType::FIELD_DOCUMENT_TYPE);
        $this->setPrimaryKey(DocumentType::FIELD_ID);

        $this->hasMany('Documents', [
            'foreignKey' => Document::FIELD_DOCUMENT_TYPE_ID
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
            ->integer(DocumentType::FIELD_ID)
            ->allowEmptyString(DocumentType::FIELD_ID, null, 'create');

        $validator
            ->scalar(DocumentType::FIELD_DOCUMENT_TYPE)
            ->maxLength(DocumentType::FIELD_DOCUMENT_TYPE, 31)
            ->notEmptyString(DocumentType::FIELD_DOCUMENT_TYPE)
            ->requirePresence(DocumentType::FIELD_DOCUMENT_TYPE)
            ->add(DocumentType::FIELD_DOCUMENT_TYPE, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique([DocumentType::FIELD_DOCUMENT_TYPE]));

        return $rules;
    }
}