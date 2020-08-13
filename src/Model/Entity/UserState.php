<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserState Entity
 *
 * @property int $id
 * @property string $user_state
 * @property bool $active
 * @property bool $expired
 * @property int|null $precedence_order
 * @property int $signature
 *
 * @property \App\Model\Entity\User[] $users
 */
class UserState extends Entity
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
        'user_state' => true,
        'active' => true,
        'expired' => true,
        'precedence_order' => true,
        'signature' => true,
        'users' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_USER_STATE = 'user_state';
    public const FIELD_ACTIVE = 'active';
    public const FIELD_EXPIRED = 'expired';
    public const FIELD_USERS = 'users';
    public const FIELD_PRECEDENCE_ORDER = 'precedence_order';
    public const FIELD_SIGNATURE = 'signature';

    public const EVALUATE_USERNAME = 0b1;
    public const EVALUATE_LOGIN_EVER = 0b10;
    public const EVALUATE_LOGIN_QUARTER = 0b100;
    public const EVALUATE_LOGIN_CAPABILITY = 0b1000;
    public const EVALUATE_ACTIVE_ROLE = 0b10000;
    public const EVALUATE_VALIDATED_EMAIL = 0b100000;
}
