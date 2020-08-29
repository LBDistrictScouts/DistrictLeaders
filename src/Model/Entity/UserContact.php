<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Datasource\FactoryLocator;
use Cake\Datasource\ModelAwareTrait;
use Cake\ORM\Entity;

/**
 * UserContact Entity
 *
 * @property int $id
 * @property string $contact_field
 * @property int $user_id
 * @property int $user_contact_type_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool $verified
 * @property bool|null $validated
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property int|null $directory_user_id
 *
 * @property \App\Model\Entity\Audit[] $audits
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\UserContactType $user_contact_type
 * @property \App\Model\Entity\Role[] $roles
 * @property \App\Model\Entity\DirectoryUser|null $directory_user
 *
 * @property \App\Model\Table\DirectoryUsersTable $DirectoryUsers
 * @property \App\Model\Table\CompassRecordsTable $CompassRecords
 * @property \App\Model\Table\UserContactTypesTable $UserContactTypes
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
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
     * Prov / PreProv Virtual Field
     *
     * @return bool|null
     */
    protected function _getValidated(): ?bool
    {
        $verified = $this->verified ?? false;
        $directoryUser = !empty($this->directory_user_id);

        return (bool)( $verified || $directoryUser );
    }

    protected $_virtual = ['validated'];

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
}
