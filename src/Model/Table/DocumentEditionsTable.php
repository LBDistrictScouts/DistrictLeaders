<?php
namespace App\Model\Table;

use App\Model\Entity\DocumentEdition;
use App\Model\Entity\FileType;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Josbeir\Filesystem\FilesystemAwareTrait;

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
    use FilesystemAwareTrait;

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
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('FileTypes', [
            'foreignKey' => 'file_type_id',
            'joinType' => 'INNER',
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
            ->scalar('file_path')
            ->maxLength('file_path', 255)
            ->allowEmptyString('file_path');

        $validator
            ->scalar('filename')
            ->maxLength('filename', 255)
            ->allowEmptyString('filename');

        $validator
            ->integer('size')
            ->allowEmptyString('size');

        $validator
            ->scalar('md5_hash')
            ->maxLength('md5_hash', 32)
            ->allowEmptyString('md5_hash');

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

    /**
     * @param array $postData Post Request Data (file upload array)
     *
     * @return \Cake\Datasource\EntityInterface|bool
     */
    public function uploadDocument($postData)
    {
        if (!key_exists('uploadedFile', $postData)) {
            return false;
        }

        /** @var \Cake\Datasource\EntityInterface $fileEntity */
        $fileEntity = $this->getFilesystem('default')->upload($postData['uploadedFile']);

        try {
            $fileType = $this->FileTypes->find()->where([FileType::FIELD_MIME => $fileEntity->get('mime')])->firstOrFail();
        } catch (RecordNotFoundException $exception) {
            return false;
        }

        $this->patchEntity($fileEntity, [
            DocumentEdition::FIELD_MD5_HASH => $fileEntity->get('hash'),
            DocumentEdition::FIELD_DOCUMENT_VERSION_ID => $postData[DocumentEdition::FIELD_DOCUMENT_VERSION_ID],
            DocumentEdition::FIELD_FILE_TYPE_ID => $fileType->get(FileType::FIELD_ID),
            DocumentEdition::FIELD_FILE_PATH => $fileEntity->get('path'),
        ]);

        return $fileEntity;
    }
}
