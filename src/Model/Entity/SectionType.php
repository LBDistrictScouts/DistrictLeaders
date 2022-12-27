<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SectionType Entity
 *
 * @property int $id
 * @property string $section_type
 * @property string $section_type_code
 * @property RoleType[] $role_types
 * @property Section[] $sections
 * @property bool $is_young_person_section
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
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
        'section_type_code' => true,
        'role_types' => true,
        'sections' => true,
    ];

    protected $_virtual = ['is_young_person_section'];

    /**
     * @return bool
     */
    protected function _getIsYoungPersonSection(): bool
    {
        return (bool)($this->section_type_code == 'l');
    }

    public const FIELD_ID = 'id';
    public const FIELD_SECTION_TYPE = 'section_type';
    public const FIELD_SECTION_TYPE_CODE = 'section_type_code';
    public const FIELD_ROLE_TYPES = 'role_types';
    public const FIELD_SECTIONS = 'sections';
    public const FIELD_IS_YOUNG_PERSON_SECTION = 'is_young_person_section';
}
