<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Directory;
use App\Model\Entity\DirectoryDomain;
use App\Utility\GoogleBuilder;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Google_Exception;
use Google_Service_Directory_Domains;

/**
 * DirectoryDomains Model
 *
 * @property DirectoriesTable&BelongsTo $Directories
 * @method DirectoryDomain get($primaryKey, $options = [])
 * @method DirectoryDomain newEntity(array $data, array $options = [])
 * @method DirectoryDomain[] newEntities(array $data, array $options = [])
 * @method DirectoryDomain|false save(EntityInterface $entity, $options = [])
 * @method DirectoryDomain saveOrFail(EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DirectoryDomain
 * patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method DirectoryDomain[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method DirectoryDomain findOrCreate($search, ?callable $callback = null, $options = [])
 * @method DirectoryDomain patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method DirectoryDomain newEmptyEntity()
 * @method DirectoryDomain[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method DirectoryDomain[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method DirectoryDomain[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method DirectoryDomain[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DirectoryDomainsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('directory_domains');
        $this->setDisplayField(DirectoryDomain::FIELD_DIRECTORY_DOMAIN);
        $this->setPrimaryKey(DirectoryDomain::FIELD_ID);

        $this->belongsTo('Directories', [
            'foreignKey' => DirectoryDomain::FIELD_DIRECTORY_ID,
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
            ->integer(DirectoryDomain::FIELD_DIRECTORY_ID)
            ->requirePresence(DirectoryDomain::FIELD_DIRECTORY_ID)
            ->notEmptyString(DirectoryDomain::FIELD_DIRECTORY_ID, null, 'create');

        $validator
            ->scalar(DirectoryDomain::FIELD_DIRECTORY_DOMAIN)
            ->maxLength(DirectoryDomain::FIELD_DIRECTORY_DOMAIN, 255)
            ->requirePresence(DirectoryDomain::FIELD_DIRECTORY_DOMAIN, 'create')
            ->notEmptyString(DirectoryDomain::FIELD_DIRECTORY_DOMAIN)
            ->add(DirectoryDomain::FIELD_DIRECTORY_DOMAIN, 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
            ]);

        $validator
            ->boolean(DirectoryDomain::FIELD_INGEST)
            ->notEmptyString(DirectoryDomain::FIELD_INGEST);

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
        $rules->add($rules->isUnique([DirectoryDomain::FIELD_DIRECTORY_DOMAIN]));
        $rules->add($rules->existsIn([DirectoryDomain::FIELD_DIRECTORY_ID], 'Directories'));

        return $rules;
    }

    /**
     * @param Directory $directory The directory to be Populated with Domains
     * @return int
     */
    public function populate(Directory $directory): int
    {
        try {
            $domainList = GoogleBuilder::getDomainList($directory);
        } catch (Google_Exception $e) {
            return 0;
        }
        $count = 0;

        /** @var Google_Service_Directory_Domains $domain */
        foreach ($domainList->getDomains() as $domain) {
            $result = $this->findOrMake($domain, $directory->id);
            if ($result) {
                $count += 1;
            }
        }

        return $count;
    }

    /**
     * @param Google_Service_Directory_Domains $directoryDomains Google Response Object
     * @param int $directoryId ID of the Parent Directory
     * @return DirectoryDomain|array|EntityInterface|false|null
     */
    public function findOrMake(Google_Service_Directory_Domains $directoryDomains, int $directoryId)
    {
        $search = [
            DirectoryDomain::FIELD_DIRECTORY_DOMAIN => $directoryDomains->getDomainName(),
            DirectoryDomain::FIELD_DIRECTORY_ID => $directoryId,
        ];

        return $this->findOrCreate($search);
    }
}
