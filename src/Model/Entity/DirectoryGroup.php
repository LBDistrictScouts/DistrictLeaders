<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DirectoryGroup Entity
 *
 * @property int $id
 * @property int $directory_id
 * @property string $directory_group_name
 * @property string $directory_group_email
 * @property string|null $directory_group_reference
 *
 * @property Directory $directory
 * @property RoleType[] $role_types
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class DirectoryGroup extends Entity
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
        'directory_group_name' => true,
        'directory_group_email' => true,
        'directory_group_reference' => true,
        'directory' => true,
        'role_types' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_DIRECTORY_ID = 'directory_id';
    public const FIELD_DIRECTORY_GROUP_NAME = 'directory_group_name';
    public const FIELD_DIRECTORY_GROUP_EMAIL = 'directory_group_email';
    public const FIELD_DIRECTORY_GROUP_REFERENCE = 'directory_group_reference';
    public const FIELD_DIRECTORY = 'directory';
    public const FIELD_ROLE_TYPES = 'role_types';
}
