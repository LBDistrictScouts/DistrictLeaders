<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Role Entity
 *
 * @property int $id
 * @property int $role_type_id
 * @property int $section_id
 * @property int $user_id
 * @property int $role_status_id
 * @property FrozenTime $created
 * @property FrozenTime|null $modified
 * @property FrozenTime|null $deleted
 * @property int|null $user_contact_id
 *
 * @property RoleType $role_type
 * @property Section $section
 * @property User $user
 * @property RoleStatus $role_status
 * @property UserContact|null $user_contact
 * @property Audit[] $audits
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Role extends Entity
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
        'role_type_id' => true,
        'section_id' => true,
        'user_id' => true,
        'role_status_id' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'user_contact_id' => true,
        'role_type' => true,
        'section' => true,
        'user' => true,
        'role_status' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_ROLE_TYPE_ID = 'role_type_id';
    public const FIELD_SECTION_ID = 'section_id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_ROLE_STATUS_ID = 'role_status_id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_ROLE_TYPE = 'role_type';
    public const FIELD_SECTION = 'section';
    public const FIELD_USER = 'user';
    public const FIELD_ROLE_STATUS = 'role_status';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_USER_CONTACT_ID = 'user_contact_id';
    public const FIELD_USER_CONTACT = 'user_contact';
    public const FIELD_AUDITS = 'audits';
}
