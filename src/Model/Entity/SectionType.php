<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SectionType Entity
 *
 * @property int $id
 * @property string $section_type
 *
 * @property \App\Model\Entity\RoleType[] $role_types
 * @property \App\Model\Entity\Section[] $sections
 */
class SectionType extends Entity
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
        'section_type' => true,
        'role_types' => true,
        'sections' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_SECTION_TYPE = 'section_type';
    public const FIELD_ROLE_TYPES = 'role_types';
    public const FIELD_SECTIONS = 'sections';
}
