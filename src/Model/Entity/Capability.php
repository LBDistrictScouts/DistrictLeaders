<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Capability Entity
 *
 * @property int $id
 * @property string $capability_code
 * @property string $capability
 * @property int $min_level
 *
 * @property \App\Model\Entity\RoleType[] $role_types
 */
class Capability extends Entity
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
        'capability_code' => true,
        'capability' => true,
        'role_types' => true,
        'min_level' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_CAPABILITY_CODE = 'capability_code';
    public const FIELD_CAPABILITY = 'capability';
    public const FIELD_MIN_LEVEL = 'min_level';
    public const FIELD_ROLE_TYPES = 'role_types';
}
