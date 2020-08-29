<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RoleType Entity
 *
 * @property int $id
 * @property string $role_type
 * @property string|null $role_abbreviation
 * @property int|null $section_type_id
 * @property int $level
 * @property int|null $role_template_id
 * @property int|null $all_role_count
 * @property int|null $active_role_count
 *
 * @property \App\Model\Entity\SectionType|null $section_type
 * @property \App\Model\Entity\RoleTemplate|null $role_template
 * @property \App\Model\Entity\Role[] $roles
 * @property \App\Model\Entity\Capability[] $capabilities
 * @property \App\Model\Entity\DirectoryGroup[] $directory_groups
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class RoleType extends Entity
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
        'role_type' => true,
        'role_abbreviation' => true,
        'section_type_id' => true,
        'level' => true,
        'role_template_id' => true,
        'all_role_count' => true,
        'active_role_count' => true,
        'section_type' => true,
        'role_template' => true,
        'roles' => true,
        'capabilities' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_ROLE_TYPE = 'role_type';
    public const FIELD_ROLE_ABBREVIATION = 'role_abbreviation';
    public const FIELD_SECTION_TYPE_ID = 'section_type_id';
    public const FIELD_LEVEL = 'level';
    public const FIELD_SECTION_TYPE = 'section_type';
    public const FIELD_ROLES = 'roles';
    public const FIELD_CAPABILITIES = 'capabilities';
    public const FIELD_ROLE_TEMPLATE_ID = 'role_template_id';
    public const FIELD_ROLE_TEMPLATE = 'role_template';
    public const FIELD_ALL_ROLE_COUNT = 'all_role_count';
    public const FIELD_ACTIVE_ROLE_COUNT = 'active_role_count';
    public const FIELD_DIRECTORY_GROUPS = 'directory_groups';
}
