<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Token;
use App\Utility\TextSafe;
use Cake\Database\Schema\TableSchemaInterface;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ModelAwareTrait;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Security;
use Cake\Validation\Validator;
use Exception;
use Queue\Model\Table\QueuedJobsTable;

/**
 * Tokens Model
 *
 * @property EmailSendsTable&BelongsTo $EmailSends
 * @property QueuedJobsTable $QueuedJobs
 * @method Token get($primaryKey, $options = [])
 * @method Token newEntity(array $data, array $options = [])
 * @method Token[] newEntities(array $data, array $options = [])
 * @method Token|false save(EntityInterface $entity, $options = [])
 * @method Token patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Token[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method Token findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 * @method Token saveOrFail(EntityInterface $entity, $options = [])
 * @method Token[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method Token newEmptyEntity()
 * @method Token[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method Token[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method Token[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TokensTable extends Table
{
    use ModelAwareTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('tokens');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ],
            ],
        ]);

        $this->belongsTo('EmailSends', [
            'foreignKey' => 'email_send_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('token')
            ->maxLength('token', 511)
            ->requirePresence('token', 'create')
            ->notEmptyString('token');

        $validator
            ->dateTime('expires')
            ->allowEmptyDateTime('expires');

        $validator
            ->dateTime('utilised')
            ->allowEmptyDateTime('utilised');

        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('hash')
            ->maxLength('hash', 511)
            ->allowEmptyString('hash');

        $validator
            ->integer('random_number')
            ->allowEmptyString('random_number');

        $validator
            ->requirePresence('token_header', 'create')
            ->notEmptyString('token_header');

        return $validator;
    }

    /**
     * @param TableSchemaInterface $schema The Schema to be modified
     * @return TableSchemaInterface
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _initializeSchema(TableSchemaInterface $schema): TableSchemaInterface
    {
        $schema->setColumnType('token_header', 'json');

        return $schema;
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
        $rules->add($rules->existsIn(['email_send_id'], 'EmailSends'));

        return $rules;
    }

    /**
     * @param EventInterface $event The Event to be processed
     * @param object $data The data to be modified
     * @param object $options The Options Contained
     * @return void
     */
    public function beforeMarshal(EventInterface $event, object $data, object $options): void
    {
        if (!isset($data['active'])) {
            // Sets Active
            $data['active'] = true;
        }
    }

    /**
     * Hashes the password before save
     *
     * @param EventInterface $event The event trigger.
     * @return true
     * @throws Exception
     */
    public function beforeSave(EventInterface $event): bool
    {
        /** @var Token $entity */
        $entity = $event->getData('entity');

        if ($entity->isNew()) {
            $entity->random_number = unpack('n', Security::randomBytes(64))[1];

            // Set Expiry Date
            $now = FrozenTime::now();
            $entity->expires = $now->addMonth(1);
        }

        return true;
    }

    /**
     * @param int $tokenId The Id of the Token
     * @return string
     */
    public function prepareToken(int $tokenId): string
    {
        $tokenRow = $this->get($tokenId, ['contain' => 'EmailSends']);

        $decrypter = Security::randomBytes(64);
        $decrypter = base64_encode($decrypter);
        $decrypter = substr($decrypter, 0, 8);

        $hash = $decrypter . $tokenRow->created . $tokenRow->random_number . $tokenRow->email_send->user_id;

        $hash = Security::hash($hash, 'sha256');

        $tokenRow->set('hash', $hash);
        $this->save($tokenRow);

        $tokenData = [
            'id' => $tokenId,
            'random_number' => $tokenRow->random_number,
        ];

        $token = json_encode($tokenData);
        $token = base64_encode($token);

        $token = $decrypter . $token;
        $token = TextSafe::encode($token);

        return $token;
    }

    /**
     * @param int $tokenId The Id of the Token
     * @return string
     */
    public function buildToken(int $tokenId): string
    {
        $token = $this->prepareToken($tokenId);

        return urlencode($token);
    }

    /**
     * @param string $tokenString The Token to be Validated & Decrypted
     * @return int|false $validation Containing the validation state & id
     */
    public function validateToken(string $tokenString): bool|int
    {
        $tokenString = urldecode($tokenString);
        $tokenString = TextSafe::decode($tokenString);
        $decrypter = substr($tokenString, 0, 8);

        $tokenString = substr($tokenString, 8);
        $tokenString = base64_decode($tokenString);
        $tokenString = json_decode($tokenString);

        if (!is_object($tokenString)) {
            return false;
        }

        $tokenRow = $this->get($tokenString->id, ['contain' => 'EmailSends']);

        if (!$tokenRow->active) {
            return false;
        }

        $tokenRow->set('utilised', FrozenTime::now());
        $this->save($tokenRow);

        if ($tokenRow->random_number <> $tokenString->random_number) {
            return false;
        }

        $testHash = $decrypter . $tokenRow->created . $tokenRow->random_number . $tokenRow->email_send->user_id;
        $testHash = Security::hash($testHash, 'sha256');

        $tokenRowHash = $tokenRow['hash'];

        if ($testHash == $tokenRowHash) {
            $this->getEventManager()->dispatch(new Event(
                'Model.Tokens.tokenValidated',
                $this,
                ['tokenId' => $tokenRow->id]
            ));

            return $tokenRow->id;
        }

        return false;
    }

    public const CLEAN_NO_CLEAN = 0;
    public const CLEAN_DEACTIVATE = 1;
    public const CLEAN_DELETED = 2;

    /**
     * @param Token $token The token to be cleaned.
     * @return int
     */
    public function cleanToken(Token $token): int
    {
        /** @var FrozenTime $expiry */
        $expiry = $token->get(Token::FIELD_EXPIRES);
        /** @var FrozenTime|null $expiry */
        $utilised = $token->get(Token::FIELD_UTILISED);
        /** @var bool $active */
        $active = $token->get(Token::FIELD_ACTIVE);

        if ((!$expiry->isFuture() || $utilised instanceof FrozenTime) && $active) {
            $token->set(Token::FIELD_ACTIVE, false);
            $this->save($token);

            return self::CLEAN_DEACTIVATE;
        }

        $now = FrozenTime::now();
        $monthAgo = $now->subMonth();

        if (!$active && $expiry->lt($monthAgo)) {
            $this->delete($token);

            return self::CLEAN_DELETED;
        }

        return self::CLEAN_NO_CLEAN;
    }

    /**
     * Clean Tokens
     *
     * @param int|null $jobId If running in an ASync Job, the ID of the job
     * @return array
     */
    public function cleanAllTokens(?int $jobId = null): array
    {
        if (!is_null($jobId)) {
            $this->loadModel('Queue.QueuedJobs');
        }

        $unchanged = 0;
        $deactivated = 0;
        $deleted = 0;
        $idx = 0;

        $tokens = $this->find('all');
        $records = $tokens->count();

        foreach ($tokens as $token) {
            $response = $this->cleanToken($token);
            $idx++;

            switch ($response) {
                case self::CLEAN_NO_CLEAN:
                    $unchanged++;
                    break;
                case self::CLEAN_DEACTIVATE:
                    $deactivated++;
                    break;
                case self::CLEAN_DELETED:
                    $deleted++;
                    break;
                default:
                    break;
            }

            if (!is_null($jobId)) {
                $this->QueuedJobs->updateProgress($jobId, $idx / $records);
            }
        }

        return compact('records', 'unchanged', 'deactivated', 'deleted');
    }

    /**
     * @param array $requestQueryParams Request Query Params
     * @return false|Token
     */
    public function validateTokenRequest(array $requestQueryParams)
    {
        if (key_exists('token', $requestQueryParams)) {
            $token = $requestQueryParams['token'];
        }
        if (key_exists('token_id', $requestQueryParams)) {
            $tokenId = $requestQueryParams['token_id'];
        }

        if (isset($token) && isset($tokenId)) {
            $valid = $this->validateToken($token);

            if ($valid && $valid == $tokenId) {
                return $this->get($valid, ['contain' => 'EmailSends.Users']);
            }
        }

        return false;
    }
}
