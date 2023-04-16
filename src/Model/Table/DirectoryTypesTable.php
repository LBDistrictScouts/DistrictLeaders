<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\DirectoryType;
use App\Model\Table\Traits\BaseInstallerTrait;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DirectoryTypes Model
 *
 * @property \App\Model\Table\DirectoriesTable&\App\Model\Table\HasMany $Directories
 * @method \App\Model\Entity\DirectoryType get($primaryKey, $options = [])
 * @method \App\Model\Entity\DirectoryType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryType|false save(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DirectoryType saveOrFail(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DirectoryType patchEntity(\App\Model\Table\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DirectoryType newEmptyEntity()
 * @method \App\Model\Entity\DirectoryType[]|\App\Model\Table\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DirectoryType[]|\App\Model\Table\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DirectoryType[]|\App\Model\Table\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DirectoryType[]|\App\Model\Table\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
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
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
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
