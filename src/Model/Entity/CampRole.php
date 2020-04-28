<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CampRole Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $camp_id
 * @property int $user_id
 * @property int $camp_role_type_id
 *
 * @property \App\Model\Entity\Camp $camp
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\CampRoleType $camp_role_type
 */
class CampRole extends Entity
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
        'camp_id' => true,
        'user_id' => true,
        'camp_role_type_id' => true,
        'camp' => true,
        'user' => true,
        'camp_role_type' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_CAMP_ID = 'camp_id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_CAMP_ROLE_TYPE_ID = 'camp_role_type_id';
    public const FIELD_CAMP = 'camp';
    public const FIELD_USER = 'user';
    public const FIELD_CAMP_ROLE_TYPE = 'camp_role_type';
}
