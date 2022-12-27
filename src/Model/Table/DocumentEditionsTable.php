<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\DocumentEdition;
use App\Model\Entity\FileType;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Josbeir\Filesystem\Exception\FilesystemException;
use Josbeir\Filesystem\FilesystemAwareTrait;
use League\Flysystem\FileNotFoundException;

/**
 * DocumentEditions Model
 *
 * @property DocumentVersionsTable&BelongsTo $DocumentVersions
 * @property FileTypesTable&BelongsTo $FileTypes
 * @method DocumentEdition get($primaryKey, $options = [])
 * @method DocumentEdition newEntity(array $data, array $options = [])
 * @method DocumentEdition[] newEntities(array $data, array $options = [])
 * @method DocumentEdition|false save(EntityInterface $entity, $options = [])
 * @method DocumentEdition saveOrFail(EntityInterface $entity, $options = [])
 * @method DocumentEdition patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method DocumentEdition[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method DocumentEdition findOrCreate($search, ?callable $callback = null, $options = [])
 * @method DocumentEdition[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @mixin TimestampBehavior
 * @method DocumentEdition newEmptyEntity()
 * @method DocumentEdition[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method DocumentEdition[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method DocumentEdition[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin TimestampBehavior
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
     * @param Validator $validator Validator instance.
     * @return Validator
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
            ->maxLength(DocumentEdition::FIELD_MD5_HASH, 40)
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
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
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
     * @return EntityInterface|bool
     */
    public function uploadDocument($postData)
    {
        debug($postData);
        if (!key_exists('uploadedFile', $postData)) {
            return false;
        }

        try {
            /** @var EntityInterface $fileEntity */
            $fileEntity = $this->getFilesystem('default')->upload($postData['uploadedFile']);
        } catch (FilesystemException $e) {
            debug('filesys');
            debug($e);

            return false;
        } catch (FileNotFoundException $e) {
            debug('not found');

            return false;
        }

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
