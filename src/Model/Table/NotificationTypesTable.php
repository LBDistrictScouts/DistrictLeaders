<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\NotificationType;
use App\Model\Entity\User;
use App\Model\Table\Traits\BaseInstallerTrait;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotificationTypes Model
 *
 * @property \App\Model\Table\NotificationsTable&\Cake\ORM\Association\HasMany $Notifications
 * @method \App\Model\Entity\NotificationType get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotificationType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotificationType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotificationType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotificationType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotificationType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotificationType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotificationType findOrCreate($search, callable $callback = null, $options = [])
 */
class NotificationTypesTable extends Table
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

        $this->setTable('notification_types');
        $this->setDisplayField(NotificationType::FIELD_NOTIFICATION_TYPE);
        $this->setPrimaryKey(NotificationType::FIELD_ID);

        $this->hasMany('Notifications', [
            'foreignKey' => 'notification_type_id',
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
            ->integer(NotificationType::FIELD_ID)
            ->allowEmptyString(NotificationType::FIELD_ID, null, 'create');

        $validator
            ->scalar(NotificationType::FIELD_NOTIFICATION_TYPE)
            ->requirePresence(NotificationType::FIELD_NOTIFICATION_TYPE, 'create')
            ->maxLength(NotificationType::FIELD_NOTIFICATION_TYPE, 45)
            ->notEmptyString(NotificationType::FIELD_NOTIFICATION_TYPE);

        $validator
            ->scalar(NotificationType::FIELD_NOTIFICATION_DESCRIPTION)
            ->requirePresence(NotificationType::FIELD_NOTIFICATION_DESCRIPTION, 'create')
            ->maxLength(NotificationType::FIELD_NOTIFICATION_DESCRIPTION, 255)
            ->notEmptyString(NotificationType::FIELD_NOTIFICATION_DESCRIPTION);

        $validator
            ->scalar(NotificationType::FIELD_ICON)
            ->requirePresence(NotificationType::FIELD_ICON, 'create')
            ->maxLength(NotificationType::FIELD_ICON, 45)
            ->notEmptyString(NotificationType::FIELD_ICON);

        $validator
            ->scalar(NotificationType::FIELD_TYPE_CODE)
            ->requirePresence(NotificationType::FIELD_TYPE_CODE, 'create')
            ->regex(NotificationType::FIELD_TYPE_CODE, '/^([A-Z]{3}(-)[A-Z]{3})$/')
            ->maxLength(NotificationType::FIELD_TYPE_CODE, 7)
            ->notEmptyString(NotificationType::FIELD_TYPE_CODE);

        $validator
            ->scalar(NotificationType::FIELD_CONTENT_TEMPLATE)
            ->requirePresence(NotificationType::FIELD_CONTENT_TEMPLATE, 'create')
            ->maxLength(NotificationType::FIELD_CONTENT_TEMPLATE, 32)
            ->notEmptyString(NotificationType::FIELD_CONTENT_TEMPLATE);

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
        $rules->add($rules->isUnique(['notification_type']));
        $rules->add($rules->isUnique(['type_code']));

        return $rules;
    }

    /**
     * install the application status config
     *
     * @return int
     */
    public function installBaseNotificationTypes()
    {
        return $this->installBase($this);
    }

    /**
     * install the application status config
     *
     * @param string $entityCode Notification Type Code
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @return \App\Model\Entity\NotificationType
     */
    public function getTypeCode(string $entityCode): NotificationType
    {
        $typeArray = $this->entityCodeSplitter($entityCode);
        $code = $typeArray['typeCode'];

        if ($this->exists(['type_code' => $code])) {
            $notificationType = $this->find()->where(['type_code' => $code])->first();
        } else {
            $notificationType = $this->find()->where(['type_code' => 'GEN-NOT'])->first();
        }

        if ($notificationType instanceof NotificationType) {
            return $notificationType;
        }

        throw new RecordNotFoundException();
    }

    /**
     * @param string $emailGenerationCode The Email Generation Code
     * @return string[]
     */
    public function entityCodeSplitter(string $emailGenerationCode): array
    {
        $type = null;
        $subType = null;
        $entityId = null;
        $instance = null;

        $codeBlocks = substr_count($emailGenerationCode, '-') + 1;
        $generationArray = explode('-', $emailGenerationCode, $codeBlocks);

        $type = $generationArray[0];

        // Sub Type
        if ($codeBlocks == 2) {
            $subType = $generationArray[1];
        }

        if ($codeBlocks >= 3) {
            $subType = $generationArray[2];
        }

        // Entity ID
        if ($codeBlocks >= 3 && is_numeric($generationArray[1])) {
            $entityId = $generationArray[1];
        }

        // Instance Count
        if ($codeBlocks >= 4 && is_numeric($generationArray[3])) {
            $instance = $generationArray[3];
        }

        $typeCode = $type . '-' . $subType;

        return compact('type', 'subType', 'entityId', 'typeCode', 'instance', 'codeBlocks');
    }

    /**
     * Function to build Notification Standard Header
     *
     * @param \App\Model\Entity\NotificationType $notificationType Notification Type for Header Build
     * @param \App\Model\Entity\User $user User for Header Context
     * @return string
     */
    public function buildNotificationHeader(NotificationType $notificationType, User $user): string
    {
        if ($notificationType->type == 'USR') {
            switch ($notificationType->sub_type) {
                case 'PWD':
                    $header = 'Password Reset for {0}';
                    break;
                case 'CCH':
                    $header = 'Permissions Changed for {0}';
                    break;
                case 'NEW':
                    $header = 'Welcome to Site {0}';
                    break;
                default:
                    return '';
            }

            return __($header, $user->full_name);
        }

        return '';
    }

    /**
     * Function to build Notification Standard Header
     *
     * @param \App\Model\Entity\NotificationType $notificationType Notification Type
     * @return array
     */
    public function buildNotificationLink(NotificationType $notificationType): array
    {
        if ($notificationType->type == 'USR') {
            switch ($notificationType->sub_type) {
                case 'PWD':
                    return [
                        'controller' => 'Users',
                        'action' => 'password',
                    ];
                case 'CCH':
                    return [
                        'controller' => 'Pages',
                        'action' => 'display',
                        'permissions',
                    ];
                case 'NEW':
                    return [
                        'controller' => 'Users',
                        'action' => 'welcome',
                    ];
                default:
                    return [];
            }
        }

        return [];
    }
}
