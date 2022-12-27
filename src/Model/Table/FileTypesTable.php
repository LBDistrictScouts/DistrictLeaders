<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\FileType;
use App\Model\Table\Traits\BaseInstallerTrait;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FileTypes Model
 *
 * @property DocumentEditionsTable&HasMany $DocumentEditions
 * @method FileType get($primaryKey, $options = [])
 * @method FileType newEntity(array $data, array $options = [])
 * @method FileType[] newEntities(array $data, array $options = [])
 * @method FileType|false save(EntityInterface $entity, $options = [])
 * @method FileType saveOrFail(EntityInterface $entity, $options = [])
 * @method FileType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method FileType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method FileType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method FileType[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method FileType newEmptyEntity()
 * @method FileType[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method FileType[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method FileType[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FileTypesTable extends Table
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

        $this->setTable('file_types');
        $this->setDisplayField(FileType::FIELD_FILE_TYPE);
        $this->setPrimaryKey('id');

        $this->hasMany('DocumentEditions', [
            'foreignKey' => 'file_type_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar(FileType::FIELD_FILE_TYPE)
            ->maxLength(FileType::FIELD_FILE_TYPE, 31)
            ->requirePresence(FileType::FIELD_FILE_TYPE, 'create')
            ->notEmptyString(FileType::FIELD_FILE_TYPE)
            ->add(FileType::FIELD_FILE_TYPE, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar(FileType::FIELD_FILE_EXTENSION)
            ->maxLength(FileType::FIELD_FILE_EXTENSION, 10)
            ->requirePresence(FileType::FIELD_FILE_EXTENSION, 'create')
            ->notEmptyString(FileType::FIELD_FILE_EXTENSION)
            ->add(FileType::FIELD_FILE_EXTENSION, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar(FileType::FIELD_MIME)
            ->maxLength(FileType::FIELD_MIME, 32)
            ->requirePresence(FileType::FIELD_MIME, 'create')
            ->notEmptyString(FileType::FIELD_MIME)
            ->add(FileType::FIELD_MIME, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique([FileType::FIELD_FILE_TYPE]));
        $rules->add($rules->isUnique([FileType::FIELD_FILE_EXTENSION]));
        $rules->add($rules->isUnique([FileType::FIELD_MIME]));

        return $rules;
    }

    /**
     * install the application status config
     *
     * @return int
     */
    public function installBaseFileTypes()
    {
        return $this->installBase($this);
    }
}
