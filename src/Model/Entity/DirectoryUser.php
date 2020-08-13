<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DirectoryUser Entity
 *
 * @property int $id
 * @property int $directory_id
 * @property string $directory_user_reference
 * @property string $given_name
 * @property string $family_name
 * @property string $primary_email
 *
 * @property \App\Model\Entity\Directory $directory
 * @property \App\Model\Entity\User[] $users
 * @property string $full_name
 * @property \App\Model\Entity\UserContact[] $user_contacts
 */
class DirectoryUser extends Entity
{
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
        'directory_id' => true,
        'directory_user_reference' => true,
        'given_name' => true,
        'family_name' => true,
        'primary_email' => true,
        'directory' => true,
    ];

    /**
     * Specifies the method for building up a user's full name.
     *
     * @return string
     */
    protected function _getFullName()
    {
        return $this->given_name . ' ' . $this->family_name;
    }

    /**
     * Exposed Virtual Properties
     *
     * @var array
     */
    protected $_virtual = ['full_name'];

    public const FIELD_ID = 'id';
    public const FIELD_DIRECTORY_ID = 'directory_id';
    public const FIELD_DIRECTORY_USER_REFERENCE = 'directory_user_reference';
    public const FIELD_GIVEN_NAME = 'given_name';
    public const FIELD_FAMILY_NAME = 'family_name';
    public const FIELD_PRIMARY_EMAIL = 'primary_email';
    public const FIELD_DIRECTORY = 'directory';
    public const FIELD_USERS = 'users';
    public const FIELD_FULL_NAME = 'full_name';
    public const FIELD_USER_CONTACTS = 'user_contacts';
}
