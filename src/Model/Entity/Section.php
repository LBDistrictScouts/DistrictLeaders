<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Section Entity
 *
 * @property int $id
 * @property string $section
 * @property int $section_type_id
 * @property int $scout_group_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\SectionType $section_type
 * @property \App\Model\Entity\ScoutGroup $scout_group
 * @property \App\Model\Entity\Role[] $roles
 * @property \Cake\I18n\FrozenTime|null $deleted
 */
class Section extends Entity
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
        'section' => true,
        'section_type_id' => true,
        'scout_group_id' => true,
        'created' => true,
        'modified' => true,
        'section_type' => true,
        'scout_group' => true,
        'roles' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_SECTION = 'section';
    public const FIELD_SECTION_TYPE_ID = 'section_type_id';
    public const FIELD_SCOUT_GROUP_ID = 'scout_group_id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_SECTION_TYPE = 'section_type';
    public const FIELD_SCOUT_GROUP = 'scout_group';
    public const FIELD_ROLES = 'roles';
    public const FIELD_DELETED = 'deleted';
}
