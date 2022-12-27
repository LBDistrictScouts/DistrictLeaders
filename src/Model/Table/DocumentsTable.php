<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Behavior\CaseableBehavior;
use App\Model\Entity\Document;
use App\Model\Entity\DocumentEdition;
use App\Model\Entity\DocumentVersion;
use App\Model\Entity\FileType;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Log\Log;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;
use Josbeir\Filesystem\Exception\FilesystemException;
use Josbeir\Filesystem\FilesystemAwareTrait;
use League\Flysystem\FileNotFoundException;
use Muffin\Trash\Model\Behavior\TrashBehavior;
use Search\Model\Behavior\SearchBehavior;

/**
 * Documents Model
 *
 * @property DocumentTypesTable&BelongsTo $DocumentTypes
 * @property DocumentVersionsTable&HasMany $DocumentVersions
 * @method Document get($primaryKey, $options = [])
 * @method Document newEntity(array $data, array $options = [])
 * @method Document[] newEntities(array $data, array $options = [])
 * @method Document|false save(EntityInterface $entity, $options = [])
 * @method Document saveOrFail(EntityInterface $entity, $options = [])
 * @method Document patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Document[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method Document findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 * @mixin TrashBehavior
 * @mixin CaseableBehavior
 * @mixin SearchBehavior
 * @method Document[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @property DocumentEditionsTable&BelongsTo $DocumentPreviews
 * @method Document newEmptyEntity()
 * @method Document[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method Document[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method Document[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DocumentsTable extends Table
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

        $this->setTable('documents');
        $this->setDisplayField('document');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');
        $this->addBehavior('Search.Search');

        $this->addBehavior('Caseable', [
            'case_columns' => [
                Document::FIELD_DOCUMENT => 't',
            ],
        ]);

        $this->belongsTo('DocumentTypes', [
            'foreignKey' => 'document_type_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('DocumentVersions', [
            'foreignKey' => 'document_id',
        ]);

        $this->belongsTo('DocumentPreviews', [
            'foreignKey' => 'document_preview_id',
            'className' => 'DocumentEditions',
            'propertyName' => 'document_preview',
            'strategy' => 'select',
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
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['document']));
        $rules->add($rules->existsIn(['document_type_id'], 'DocumentTypes'));

        return $rules;
    }

    /**
     * @param array $postData Post Request Data (file upload array)
     * @param Document $document The Document Entity
     * @param string $fileSystem The configured Filesystem Name
     * @return EntityInterface|void
     */
    public function uploadDocument(
        array $postData,
        ?Document $document = null,
        string $fileSystem = 'default'
    ): ?EntityInterface {
        if (!key_exists('uploadedFile', $postData)) {
            return null;
        }

        try {
            /** @var EntityInterface $fileEntity */
            $fileEntity = $this->getFilesystem($fileSystem)->upload($postData['uploadedFile']);
        } catch (FilesystemException $e) {
            return null;
        } catch (FileNotFoundException $e) {
            return null;
        }

        if (is_null($document)) {
            $document = $this->newEmptyEntity();
        }

        $mime = $fileEntity->get(FileType::FIELD_MIME);

        try {
            $fileType = $this->DocumentVersions->DocumentEditions->FileTypes->find()->where([
                FileType::FIELD_MIME => $mime,
            ])->firstOrFail();
        } catch (RecordNotFoundException $exception) {
            Log::error('File with mime type: ' . $mime . ' failed upload.');

            return null;
        }

        $documentName = explode('.', $fileEntity->get(DocumentEdition::FIELD_FILENAME))[0];
        $documentName = Inflector::humanize(Inflector::underscore($documentName));

        $document = $this->patchEntity($document, [
            Document::FIELD_DOCUMENT => $documentName,
            Document::FIELD_DOCUMENT_TYPE_ID => $postData[Document::FIELD_DOCUMENT_TYPE_ID],
        ]);
        $documentVersion = $this->DocumentVersions->newEntity([
            DocumentVersion::FIELD_VERSION_NUMBER => 1,
        ]);
        $documentEdition = $this->DocumentVersions->DocumentEditions->newEntity([
            DocumentEdition::FIELD_FILENAME => $fileEntity->get(DocumentEdition::FIELD_FILENAME),
            DocumentEdition::FIELD_MD5_HASH => $fileEntity->get('hash'),
            DocumentEdition::FIELD_FILE_TYPE_ID => $fileType->get(FileType::FIELD_ID),
            DocumentEdition::FIELD_FILE_PATH => $fileEntity->get('path'),
            DocumentEdition::FIELD_SIZE => $fileEntity->get(DocumentEdition::FIELD_SIZE),
        ]);

        $document = $this->save($document);
        $documentVersion->set(DocumentVersion::FIELD_DOCUMENT_ID, $document->get(Document::FIELD_ID));

        $documentVersion = $this->DocumentVersions->save($documentVersion);
        $documentEdition->set(
            DocumentEdition::FIELD_DOCUMENT_VERSION_ID,
            $documentVersion->get(DocumentVersion::FIELD_ID)
        );

        $this->DocumentVersions->DocumentEditions->save($documentEdition);

        return $this->get($document->id, ['contain' => 'DocumentVersions.DocumentEditions']);
    }
}
