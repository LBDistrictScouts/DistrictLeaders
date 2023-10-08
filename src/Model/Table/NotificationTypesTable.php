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
 * @property \App\Model\Table\NotificationsTable&\App\Model\Table\HasMany $Notifications
 * @method \App\Model\Entity\NotificationType get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotificationType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\NotificationType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotificationType|false save(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotificationType saveOrFail(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotificationType patchEntity(\App\Model\Table\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotificationType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotificationType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\NotificationType newEmptyEntity()
 * @method \App\Model\Entity\NotificationType[]|\App\Model\Table\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\NotificationType[]|\App\Model\Table\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\NotificationType[]|\App\Model\Table\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\NotificationType[]|\App\Model\Table\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
            'dependent' => true,
            'cascadeCallbacks' => true,
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
    public function installBaseNotificationTypes(): int
    {
        return $this->installBase($this);
    }

    /**
     * install the application status config
     *
     * @param string $emailGenerationCode Notification Type Code
     * @return \App\Model\Entity\NotificationType
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     */
    public function getTypeCode(string $emailGenerationCode): NotificationType
    {
        $typeArray = $this->entityCodeSplitter($emailGenerationCode);
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
     * @param string $typeCode Code Type to Get Entity For
     * @return string
     */
    public function getTypeEntity(string $typeCode): string
    {
        if ($typeCode == 'ROL') {
            return 'Roles';
        }

        return 'Users';
    }

    /**
     * @param string $emailGenerationCode The Email Generation Code
     * @return array<string>
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
     * @param array|null $data Additional Notification Context Data
     * @return string
     */
    public function buildNotificationHeader(NotificationType $notificationType, User $user, ?array $data): string
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

        if ($notificationType->type == 'ROL') {
            switch ($notificationType->sub_type) {
                case 'NEW':
                    if (is_array($data) && key_exists('role_type', $data)) {
                        $header = 'New Role {0} added to {1}';

                        return __($header, $data['role_type'], $user->full_name);
                    } else {
                        $header = 'New Role added to {0}';
                    }
                    break;
                case 'CNG':
                    if (is_array($data) && key_exists('role_type', $data)) {
                        $header = 'Changes to Role {0} for {1}';

                        return __($header, $data['role_type'], $user->full_name);
                    } else {
                        $header = 'Changes to Role for {0}';
                    }
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
     * @param array|null $data Additional Notification Context Data
     * @return array
     */
    public function buildNotificationLink(NotificationType $notificationType, ?array $data = null): array
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

        if ($notificationType->type == 'ROL') {
            switch ($notificationType->sub_type) {
                case 'CNG':
                case 'NEW':
                    if (is_array($data) && key_exists('role_id', $data)) {
                        return [
                            'controller' => 'Roles',
                            'action' => 'view',
                            $data['role_id'],
                        ];
                    }

                    return [
                        'controller' => 'Users',
                        'action' => 'self',
                    ];
                default:
                    return [];
            }
        }

        return [];
    }
}
