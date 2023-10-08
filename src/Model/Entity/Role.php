<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Role Entity
 *
 * @property int $id
 * @property int $role_type_id
 * @property int $section_id
 * @property int $user_id
 * @property int $role_status_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property int|null $user_contact_id
 *
 * @property \App\Model\Entity\RoleType $role_type
 * @property \App\Model\Entity\Section $section
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\RoleStatus $role_status
 * @property \App\Model\Entity\UserContact|null $user_contact
 * @property \App\Model\Entity\Audit[] $audits
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
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
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
