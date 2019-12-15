<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Camp Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string $camp_name
 * @property int $camp_type_id
 * @property \Cake\I18n\FrozenTime $camp_start
 * @property \Cake\I18n\FrozenTime $camp_end
 *
 * @property \App\Model\Entity\CampType $camp_type
 * @property \App\Model\Entity\CampRole[] $camp_roles
 */
class Camp extends Entity
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
        'deleted' => true,
        'camp_name' => true,
        'camp_type_id' => true,
        'camp_start' => true,
        'camp_end' => true,
        'camp_type' => true,
        'camp_roles' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_CAMP_NAME = 'camp_name';
    public const FIELD_CAMP_TYPE_ID = 'camp_type_id';
    public const FIELD_CAMP_START = 'camp_start';
    public const FIELD_CAMP_END = 'camp_end';
    public const FIELD_CAMP_TYPE = 'camp_type';
    public const FIELD_CAMP_ROLES = 'camp_roles';
}
