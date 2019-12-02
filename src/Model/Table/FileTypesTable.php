<?php
namespace App\Model\Table;

use App\Model\Entity\FileType;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FileTypes Model
 *
 * @property \App\Model\Table\DocumentEditionsTable&\Cake\ORM\Association\HasMany $DocumentEditions
 *
 * @method FileType get($primaryKey, $options = [])
 * @method FileType newEntity($data = null, array $options = [])
 * @method FileType[] newEntities(array $data, array $options = [])
 * @method FileType|false save(EntityInterface $entity, $options = [])
 * @method FileType saveOrFail(EntityInterface $entity, $options = [])
 * @method FileType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method FileType[] patchEntities($entities, array $data, array $options = [])
 * @method FileType findOrCreate($search, callable $callback = null, $options = [])
 */
class FileTypesTable extends Table
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

        $this->setTable('file_types');
        $this->setDisplayField('file_type');
        $this->setPrimaryKey('id');

        $this->hasMany('DocumentEditions', [
            'foreignKey' => 'file_type_id'
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
            ->scalar('file_type')
            ->maxLength('file_type', 31)
            ->requirePresence('file_type', 'create')
            ->notEmptyString('file_type')
            ->add('file_type', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('file_extension')
            ->maxLength('file_extension', 10)
            ->requirePresence('file_extension', 'create')
            ->notEmptyString('file_extension')
            ->add('file_extension', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['file_type']));
        $rules->add($rules->isUnique(['file_extension']));

        return $rules;
    }

    /**
     * install the application status config
     *
     * @return mixed
     */
    public function installBaseTypes()
    {
        $base = Configure::read('fileTypes');

        $total = 0;

        foreach ($base as $baseType) {
            $query = $this->find()->where([FileType::FIELD_FILE_EXTENSION => $baseType[FileType::FIELD_FILE_EXTENSION]]);
            $status = $this->newEntity();
            if ($query->count() > 0) {
                $status = $query->first();
            }
            $this->patchEntity($status, $baseType);
            if ($this->save($status)) {
                $total += 1;
            }
        }

        return $total;
    }
}
