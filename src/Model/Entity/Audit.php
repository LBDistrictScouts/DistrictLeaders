<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Audit Entity
 *
 * @property int $id
 * @property string $audit_field
 * @property string $audit_table
 * @property string|null $original_value
 * @property string $modified_value
 * @property int|null $user_id
 * @property int $audit_record_id
 * @property FrozenTime $change_date
 *
 * @property User|null $user
 * @property User $changed_user
 * @property Role $changed_role
 * @property ScoutGroup $changed_scout_group
 * @property UserContact $changed_user_contact
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @property Section $changed_section
 *
 * @property User $new_user
 * @property UserContact $new_user_contact
 * @property Section $new_section
 * @property RoleStatus $new_role_status
 * @property RoleType $new_role_type
 *
 * @property User|null $original_user
 * @property UserContact|null $original_user_contact
 * @property Section|null $original_section
 * @property RoleStatus|null $original_role_status
 * @property RoleType|null $original_role_type
 */
class Audit extends Entity
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
        'audit_field' => true,
        'audit_table' => true,
        'original_value' => true,
        'modified_value' => true,
        'user_id' => true,
        'change_date' => true,
        'user' => true,
        'audit_record_id' => true,
        'changed_user' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_AUDIT_FIELD = 'audit_field';
    public const FIELD_AUDIT_TABLE = 'audit_table';
    public const FIELD_ORIGINAL_VALUE = 'original_value';
    public const FIELD_MODIFIED_VALUE = 'modified_value';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_AUDIT_RECORD_ID = 'audit_record_id';
    public const FIELD_CHANGE_DATE = 'change_date';
    public const FIELD_USER = 'user';
    public const FIELD_CHANGED_USER = 'changed_user';
    public const FIELD_CHANGED_ROLE = 'changed_role';
    public const FIELD_CHANGED_SCOUT_GROUP = 'changed_scout_group';
    public const FIELD_CHANGED_USER_CONTACT = 'changed_user_contact';
    public const FIELD_CHANGED_SECTION = 'changed_section';
    public const FIELD_NEW_USER = 'new_user';
    public const FIELD_NEW_USER_CONTACT = 'new_user_contact';
    public const FIELD_NEW_SECTION = 'new_section';
    public const FIELD_NEW_ROLE_STATUS = 'new_role_status';
    public const FIELD_NEW_ROLE_TYPE = 'new_role_type';
    public const FIELD_ORIGINAL_USER = 'original_user';
    public const FIELD_ORIGINAL_USER_CONTACT = 'original_user_contact';
    public const FIELD_ORIGINAL_SECTION = 'original_section';
    public const FIELD_ORIGINAL_ROLE_STATUS = 'original_role_status';
    public const FIELD_ORIGINAL_ROLE_TYPE = 'original_role_type';
}
