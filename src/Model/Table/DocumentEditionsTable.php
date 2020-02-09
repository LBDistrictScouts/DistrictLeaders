<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\DocumentEdition;
use App\Model\Entity\FileType;
use Cake\Datasource\Exception\RecordNotFoundException;
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
 * @method \App\Model\Entity\DocumentEdition get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentEdition newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentEdition[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentEdition|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentEdition saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentEdition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentEdition[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentEdition findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @method \App\Model\Entity\DocumentEdition[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
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
    public function initialize(array $config): void
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
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer(DocumentEdition::FIELD_ID)
            ->allowEmptyString(DocumentEdition::FIELD_ID, null, 'create');

        $validator
            ->scalar(DocumentEdition::FIELD_FILE_PATH)
            ->maxLength(DocumentEdition::FIELD_FILE_PATH, 255)
            ->requirePresence(DocumentEdition::FIELD_FILE_PATH, 'create')
            ->notEmptyString(DocumentEdition::FIELD_FILE_PATH);

        $validator
            ->scalar(DocumentEdition::FIELD_FILENAME)
            ->maxLength(DocumentEdition::FIELD_FILENAME, 255)
            ->requirePresence(DocumentEdition::FIELD_FILENAME, 'create')
            ->notEmptyString(DocumentEdition::FIELD_FILENAME);

        $validator
            ->integer(DocumentEdition::FIELD_SIZE)
            ->allowEmptyString(DocumentEdition::FIELD_SIZE);

        $validator
            ->scalar(DocumentEdition::FIELD_MD5_HASH)
            ->requirePresence(DocumentEdition::FIELD_MD5_HASH, false)
            ->maxLength(DocumentEdition::FIELD_MD5_HASH, 32)
            ->allowEmptyString(DocumentEdition::FIELD_MD5_HASH);

        $validator
            ->requirePresence(DocumentEdition::FIELD_DOCUMENT_VERSION_ID, 'create')
            ->notEmptyString(DocumentEdition::FIELD_DOCUMENT_VERSION_ID);

        $validator
            ->requirePresence(DocumentEdition::FIELD_FILE_TYPE_ID, 'create')
            ->notEmptyString(DocumentEdition::FIELD_FILE_TYPE_ID);

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
        $rules->add($rules->existsIn([DocumentEdition::FIELD_DOCUMENT_VERSION_ID], 'DocumentVersions'));
        $rules->add($rules->existsIn([DocumentEdition::FIELD_FILE_TYPE_ID], 'FileTypes'));

        $rules->add($rules->isUnique([
            DocumentEdition::FIELD_FILE_TYPE_ID,
            DocumentEdition::FIELD_DOCUMENT_VERSION_ID,
        ]));

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
            $fileType = $this->FileTypes
                ->find()
                ->where([FileType::FIELD_MIME => $fileEntity->get('mime')])
                ->firstOrFail();
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
