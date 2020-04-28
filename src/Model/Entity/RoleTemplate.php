<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RoleTemplate Entity
 *
 * @property int $id
 * @property string $role_template
 * @property array $template_capabilities
 * @property int $indicative_level
 *
 * @property \App\Model\Entity\RoleType[] $role_types
 */
class RoleTemplate extends Entity
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
        'role_template' => true,
        'template_capabilities' => true,
        'indicative_level' => true,
        'role_types' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_ROLE_TEMPLATE = 'role_template';
    public const FIELD_TEMPLATE_CAPABILITIES = 'template_capabilities';
    public const FIELD_INDICATIVE_LEVEL = 'indicative_level';
    public const FIELD_ROLE_TYPES = 'role_types';
}
