<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RoleType Entity
 *
 * @property int $id
 * @property string $role_type
 * @property string|null $role_abbreviation
 * @property int|null $section_type_id
 *
 * @property \App\Model\Entity\SectionType $section_type
 * @property \App\Model\Entity\Role[] $roles
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
        'section_type' => true,
        'roles' => true
    ];
}
