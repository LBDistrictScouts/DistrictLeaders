<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
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
 * @property FrozenTime $created
 * @property FrozenTime|null $modified
 *
 * @property string $clean_domain
 *
 * @property Section[] $sections
 * @property FrozenTime|null $deleted
 * @property string|null $uuid
 * @property bool $public
 * @property Audit[] $audits
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @property Section[] $leader_sections
 * @property Section[] $committee_sections
 * @property Section[] $team_sections
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
        'sections' => true,
    ];

    /**
     * @param string $value The Domain
     * @return string
     */
    protected function _setGroupDomain(string $value): string
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

    /**
     * Specifies the method for building up a user's full name.
     *
     * @return string
     */
    protected function _getCleanDomain(): string
    {
        return str_replace('https://', '', $this->group_domain ?? '');
    }

    /**
     * Exposed Virtual Properties
     *
     * @var array
     */
    protected $_virtual = ['clean_domain'];

    public const FIELD_ID = 'id';
    public const FIELD_SCOUT_GROUP = 'scout_group';
    public const FIELD_GROUP_ALIAS = 'group_alias';
    public const FIELD_NUMBER_STRIPPED = 'number_stripped';
    public const FIELD_CHARITY_NUMBER = 'charity_number';
    public const FIELD_GROUP_DOMAIN = 'group_domain';
    public const FIELD_CLEAN_DOMAIN = 'clean_domain';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_SECTIONS = 'sections';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_UUID = 'uuid';
    public const FIELD_PUBLIC = 'public';
    public const FIELD_AUDITS = 'audits';
    public const FIELD_LEADER_SECTIONS = 'leader_sections';
    public const FIELD_COMMITTEE_SECTIONS = 'committee_sections';
    public const FIELD_TEAM_SECTIONS = 'team_sections';
}
