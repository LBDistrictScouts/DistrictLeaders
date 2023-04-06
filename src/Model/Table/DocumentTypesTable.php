<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Document;
use App\Model\Entity\DocumentType;
use App\Model\Table\Traits\BaseInstallerTrait;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentTypes Model
 *
 * @property DocumentsTable&HasMany $Documents
 * @method DocumentType get($primaryKey, $options = [])
 * @method DocumentType newEntity(array $data, array $options = [])
 * @method DocumentType[] newEntities(array $data, array $options = [])
 * @method DocumentType|false save(EntityInterface $entity, $options = [])
 * @method DocumentType saveOrFail(EntityInterface $entity, $options = [])
 * @method DocumentType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method DocumentType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method DocumentType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method DocumentType newEmptyEntity()
 * @method DocumentType[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method DocumentType[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method DocumentType[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method DocumentType[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DocumentTypesTable extends Table
{
    use BaseInstallerTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('document_types');
        $this->setDisplayField(DocumentType::FIELD_DOCUMENT_TYPE);
        $this->setPrimaryKey(DocumentType::FIELD_ID);

        $this->hasMany('Documents', [
            'foreignKey' => Document::FIELD_DOCUMENT_TYPE_ID,
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
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

        $validator
            ->scalar(DocumentType::FIELD_SPECIAL_CAPABILITY)
            ->maxLength(DocumentType::FIELD_SPECIAL_CAPABILITY, 64)
            ->allowEmptyString(DocumentType::FIELD_SPECIAL_CAPABILITY);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique([DocumentType::FIELD_DOCUMENT_TYPE]));

        return $rules;
    }

    /**
     * install the application status config
     *
     * @return int
     */
    public function installBaseDocumentTypes(): int
    {
        return $this->installBase($this);
    }
}
