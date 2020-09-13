<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PasswordState Entity
 *
 * @property int $id
 * @property string $user_state
 * @property bool $active
 * @property bool $expired
 *
 * @property \App\Model\Entity\User[] $users
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class PasswordState extends Entity
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
        'users' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_USER_STATE = 'user_state';
    public const FIELD_ACTIVE = 'active';
    public const FIELD_EXPIRED = 'expired';
    public const FIELD_USERS = 'users';
}
