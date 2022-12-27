<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Table\CompassRecordsTable;
use App\Model\Table\DirectoryUsersTable;
use App\Model\Table\UserContactTypesTable;
use Cake\Datasource\FactoryLocator;
use Cake\Datasource\ModelAwareTrait;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * UserContact Entity
 *
 * @property int $id
 * @property string $contact_field
 * @property int $user_id
 * @property int $user_contact_type_id
 * @property FrozenTime $created
 * @property FrozenTime|null $modified
 * @property bool $verified
 * @property bool|null $validated
 * @property FrozenTime|null $deleted
 * @property int|null $directory_user_id
 *
 * @property Audit[] $audits
 * @property User $user
 * @property UserContactType $user_contact_type
 * @property Role[] $roles
 * @property DirectoryUser|null $directory_user
 *
 * @property DirectoryUsersTable $DirectoryUsers
 * @property CompassRecordsTable $CompassRecords
 * @property UserContactTypesTable $UserContactTypes
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @property int $validation_state
 */
class UserContact extends Entity
{
    use ModelAwareTrait;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'contact_field' => true,
        'user_id' => true,
        'user_contact_type_id' => true,
        'created' => true,
        'modified' => true,
        'verified' => true,
        'deleted' => true,
        'directory_user_id' => true,
        'audits' => true,
        'user' => true,
        'user_contact_type' => true,
        'roles' => true,
    ];

    /**
     * Function to check alternative Verification Methods
     *
     * @param string $contactField The Contact Field being Set
     * @return bool
     */
    protected function _setContactField(string $contactField)
    {
        if ($this->verified) {
            return $contactField;
        }

        $this->UserContactTypes = FactoryLocator::get('Table')->get('UserContactTypes');

        $emailType = $this->UserContactTypes
            ->find()
            ->where([UserContactType::FIELD_USER_CONTACT_TYPE => 'Email'])
            ->first()
            ->id;

        if ($this->user_contact_type_id == $emailType) {
            $this->DirectoryUsers = FactoryLocator::get('Table')->get('DirectoryUsers');

            $primaryEmail = [DirectoryUser::FIELD_PRIMARY_EMAIL => $contactField];
            if ($this->DirectoryUsers->exists($primaryEmail)) {
                $this->verified = true;
            }
        }

        return $contactField;
    }

    /**
     * Validated Virtual Field
     *
     * @return bool|null
     */
    protected function _getValidated(): ?bool
    {
        $verified = $this->verified ?? false;
        $directoryUser = !empty($this->directory_user_id);

        return (bool)( $verified || $directoryUser );
    }

    /**
     * Validation State Virtual Field
     *
     * @return int
     */
    protected function _getValidationState(): int
    {
        if ($this->verified) {
            return 2;
        }

        if ($this->validated) {
            return 1;
        }

        return 0;
    }

    protected $_virtual = ['validated', 'validation_state'];

    public const FIELD_ID = 'id';
    public const FIELD_CONTACT_FIELD = 'contact_field';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_USER_CONTACT_TYPE_ID = 'user_contact_type_id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_VERIFIED = 'verified';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_DIRECTORY_USER_ID = 'directory_user_id';
    public const FIELD_USER = 'user';
    public const FIELD_ROLES = 'roles';
    public const FIELD_USER_CONTACT_TYPE = 'user_contact_type';
    public const FIELD_AUDITS = 'audits';
    public const FIELD_DIRECTORY_USER = 'directory_user';
    public const FIELD_VALIDATED = 'validated';
    public const FIELD_VALIDATION_STATE = 'validation_state';
}
