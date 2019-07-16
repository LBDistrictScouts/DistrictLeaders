<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ScoutGroup Entity
 *
 * @property int $id
 * @property string $scout_group
 * @property string|null $group_alias
 * @property int|null $number_stripped
 * @property int|null $charity_number
 * @property string|null $group_domain
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Section[] $sections
 */
class ScoutGroup extends Entity
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
        'scout_group' => true,
        'group_alias' => true,
        'number_stripped' => true,
        'charity_number' => true,
        'group_domain' => true,
        'created' => true,
        'modified' => true,
        'sections' => true
    ];

    /**
     * @param string $value The Domain
     *
     * @return string
     */
    protected function _setGroupDomain($value)
    {
        if (strlen($value)) {
            $value = strtolower($value);
            if (strpos($value, 'www.') !== false) {
                $value = str_replace('www.', '', $value);
            }
            if (!(strpos($value, 'http') !== false)) {
                $value = 'https://' . $value;
            }
        }

        return $value;
    }

    public const FIELD_ID = 'id';
    public const FIELD_SCOUT_GROUP = 'scout_group';
    public const FIELD_GROUP_ALIAS = 'group_alias';
    public const FIELD_NUMBER_STRIPPED = 'number_stripped';
    public const FIELD_CHARITY_NUMBER = 'charity_number';
    public const FIELD_GROUP_DOMAIN = 'group_domain';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_SECTIONS = 'sections';
}
