<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * CampRoleType Entity
 *
 * @property int $id
 * @property FrozenTime $created
 * @property FrozenTime|null $modified
 * @property string $camp_role_type
 *
 * @property CampRole[] $camp_roles
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class CampRoleType extends Entity
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
        'created' => true,
        'modified' => true,
        'camp_role_type' => true,
        'camp_roles' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_CAMP_ROLE_TYPE = 'camp_role_type';
    public const FIELD_CAMP_ROLES = 'camp_roles';
}
