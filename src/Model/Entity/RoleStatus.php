<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RoleStatus Entity
 *
 * @property int $id
 * @property string $role_status
 *
 * @property \App\Model\Entity\Role[] $roles
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class RoleStatus extends Entity
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
        'role_status' => true,
        'roles' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_ROLE_STATUS = 'role_status';
    public const FIELD_ROLES = 'roles';
}
