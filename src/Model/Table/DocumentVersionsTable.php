<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Document;
use App\Model\Entity\DocumentEdition;
use App\Model\Entity\DocumentVersion;
use App\Model\Entity\FileType;
use Cake\Database\Schema\TableSchemaInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Josbeir\Filesystem\FilesystemAwareTrait;

/**
 * DocumentVersions Model
 *
 * @property \App\Model\Table\DocumentsTable&\Cake\ORM\Association\BelongsTo $Documents
 * @property \App\Model\Table\DocumentEditionsTable&\Cake\ORM\Association\HasMany $DocumentEditions
 * @property \App\Model\Table\CompassRecordsTable&\Cake\ORM\Association\HasMany $CompassRecords
 * @method \App\Model\Entity\DocumentVersion get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentVersion newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentVersion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentVersion|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentVersion saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentVersion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentVersion[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentVersion findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DocumentVersion[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @method \App\Model\Entity\DocumentVersion newEmptyEntity()
 * @method \App\Model\Entity\DocumentVersion[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DocumentVersion[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DocumentVersion[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DocumentVersionsTable extends Table
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

        $this->setTable('document_versions');
        $this->setDisplayField(DocumentVersion::FIELD_VERSION_NUMBER);
        $this->setPrimaryKey(DocumentVersion::FIELD_ID);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Documents', [
            'foreignKey' => 'document_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('DocumentEditions', [
            'foreignKey' => 'document_version_id',
        ]);
        $this->hasMany('CompassRecords', [
            'foreignKey' => 'document_version_id',
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
            ->integer('version_number')
            ->requirePresence('version_number', 'create')
            ->notEmptyString('version_number');

        $validator
            ->integer('document_id')
            ->requirePresence('document_id', 'create')
            ->notEmptyString('document_id');

        $validator
            ->isArray(DocumentVersion::FIELD_FIELD_MAPPING)
            ->allowEmptyArray(DocumentVersion::FIELD_FIELD_MAPPING);

        return $validator;
    }

    /**
     * @param \Cake\Database\Schema\TableSchemaInterface $schema The Schema to be modified
     * @return \Cake\Database\Schema\TableSchemaInterface
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _initializeSchema(TableSchemaInterface $schema): TableSchemaInterface
    {
        $schema->setColumnType(DocumentVersion::FIELD_FIELD_MAPPING, 'json');

        return $schema;
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
        $rules->add($rules->existsIn(['document_id'], 'Documents'));

        $rules->add($rules->isUnique(['version_number', 'document_id']));

        return $rules;
    }

    /**
     * Finder Method for Document List
     *
     * @param \Cake\ORM\Query $query The Query to be Modified
     * @param array $options The Options passed
     * @return \Cake\ORM\Query
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    public function findDocumentList(Query $query, array $options)
    {
        return $query->contain('Documents')
            ->find('list', array_merge($options, [
                'valueField' => function ($document_version) {
                    /** @var \App\Model\Entity\DocumentVersion $document_version */
                    return $document_version->document->get(Document::FIELD_DOCUMENT)
                           . ' - '
                           . $document_version->get(DocumentVersion::FIELD_VERSION_NUMBER);
                },
            ]));
    }

    /**
     * @param string $mime The FileType for Selection
     * @param \App\Model\Entity\DocumentVersion $version The DocumentVersion
     * @return \App\Model\Entity\DocumentEdition|false
     */
    public function getFileTypeEdition(string $mime, DocumentVersion $version)
    {
        $where = [FileType::FIELD_MIME => $mime];

        if ($this->DocumentEditions->FileTypes->exists($where)) {
            $fileType = $this->DocumentEditions->FileTypes->find()->where($where)->first();

            $editionQuery = $this->DocumentEditions->find()->where([
                DocumentEdition::FIELD_DOCUMENT_VERSION_ID => $version->id,
                DocumentEdition::FIELD_FILE_TYPE_ID => $fileType->id,
            ]);

            /** @var \App\Model\Entity\DocumentEdition $edition */
            $edition = $editionQuery->first();
            if ($editionQuery->count() == 1) {
                return $edition;
            }
        }

        return false;
    }

    /**
     * @param \App\Model\Entity\DocumentVersion $documentVersion The Document Version for Parsing
     * @return int
     */
    public function importCompassRecords(DocumentVersion $documentVersion): int
    {
        $edition = $this->getFileTypeEdition('text/csv', $documentVersion);

        $fields = [];
        if (
            $documentVersion->has($documentVersion::FIELD_FIELD_MAPPING)
            && key_exists('mapped', $documentVersion->field_mapping)
        ) {
            $fields = $documentVersion->field_mapping['mapped'];
        }

        if ($edition instanceof DocumentEdition) {
            $data = $this->CompassRecords->importCsv($edition->read(), $fields, ['text' => true]);

            return $this->CompassRecords->parseImportedData($data, $documentVersion);
        }

        return 0;
    }

    /**
     * @param \App\Model\Entity\DocumentVersion $documentVersion The Document Version for Parsing
     * @return array
     */
    public function mapCompassRecords(DocumentVersion $documentVersion): array
    {
        $edition = $this->getFileTypeEdition('text/csv', $documentVersion);

        if ($edition instanceof DocumentEdition) {
            return $this->CompassRecords->importCsv($edition->read(), [], ['text' => true], true);
        }

        return ['fields' => [], 'original' => []];
    }
}
