<?php
declare(strict_types=1);

namespace App\Model\Entity;

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
 * @property \Cake\I18n\FrozenTime|null $deleted
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Role[] $roles
 * @property \App\Model\Entity\UserContactType $user_contact_type
 * @property \App\Model\Entity\Audit[] $audits
 */
class UserContact extends Entity
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
        'contact_field' => true,
        'user_id' => true,
        'user_contact_type_id' => true,
        'created' => true,
        'modified' => true,
        'verified' => true,
        'deleted' => true,
        'audits' => true,
        'user' => true,
        'user_contact_type' => true,
        'roles' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_CONTACT_FIELD = 'contact_field';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_USER_CONTACT_TYPE_ID = 'user_contact_type_id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_VERIFIED = 'verified';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_USER = 'user';
    public const FIELD_ROLES = 'roles';
    public const FIELD_USER_CONTACT_TYPE = 'user_contact_type';
    public const FIELD_AUDITS = 'audits';
}
