<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\DirectoryType;
use App\Model\Table\Traits\BaseInstallerTrait;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DirectoryTypes Model
 *
 * @property DirectoriesTable&HasMany $Directories
 * @method DirectoryType get($primaryKey, $options = [])
 * @method DirectoryType newEntity(array $data, array $options = [])
 * @method DirectoryType[] newEntities(array $data, array $options = [])
 * @method DirectoryType|false save(EntityInterface $entity, $options = [])
 * @method DirectoryType saveOrFail(EntityInterface $entity, $options = [])
 * @method DirectoryType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method DirectoryType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method DirectoryType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method DirectoryType newEmptyEntity()
 * @method DirectoryType[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method DirectoryType[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method DirectoryType[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method DirectoryType[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DirectoryTypesTable extends Table
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

        $this->setTable('directory_types');
        $this->setDisplayField(DirectoryType::FIELD_DIRECTORY_TYPE);
        $this->setPrimaryKey(DirectoryType::FIELD_ID);

        $this->hasMany('Directories', [
            'foreignKey' => 'directory_type_id',
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
            ->scalar('directory_type')
            ->maxLength('directory_type', 64)
            ->requirePresence('directory_type', 'create')
            ->notEmptyString('directory_type')
            ->add('directory_type', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('directory_type_code')
            ->maxLength('directory_type_code', 64)
            ->requirePresence('directory_type_code', 'create')
            ->notEmptyString('directory_type_code')
            ->add('directory_type_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['directory_type']));
        $rules->add($rules->isUnique(['directory_type_code']));

        return $rules;
    }

    /**
     * Function to Install Base Directory Type
     *
     * @return int
     */
    public function installBaseDirectoryTypes(): int
    {
        return $this->installBase($this);
    }
}
