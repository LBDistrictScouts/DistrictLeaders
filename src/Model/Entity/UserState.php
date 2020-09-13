<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Core\Configure;
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
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @property bool $is_email_send_active
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

    /**
     * Specifies the method for building up a user's full name.
     *
     * @return bool
     */
    protected function _getIsEmailSendActive(): bool
    {
        $auto = Configure::read('App.autoActivating', false);

        if ($auto && $this->signature != 0) {
            return true;
        }

        $activated = (bool)(($this->signature & self::EVALUATE_ACTIVATED) > 0);
        if ($activated) {
            return true;
        }

        return $this->active;
    }

    protected $_virtual = [
        'is_email_send_active',
    ];

    public const FIELD_ID = 'id';
    public const FIELD_USER_STATE = 'user_state';
    public const FIELD_ACTIVE = 'active';
    public const FIELD_EXPIRED = 'expired';
    public const FIELD_USERS = 'users';
    public const FIELD_PRECEDENCE_ORDER = 'precedence_order';
    public const FIELD_SIGNATURE = 'signature';
    public const FIELD_IS_EMAIL_SEND_ACTIVE = 'is_email_send_active';

    public const EVALUATE_BLANK = 0;
    public const EVALUATE_USERNAME = 0b1;
    public const EVALUATE_LOGIN_EVER = 0b10;
    public const EVALUATE_LOGIN_QUARTER = 0b100;
    public const EVALUATE_LOGIN_CAPABILITY = 0b1000;
    public const EVALUATE_ACTIVE_ROLE = 0b10000;
    public const EVALUATE_VALIDATED_EMAIL = 0b100000;
    public const EVALUATE_ACTIVATED = 0b1000000;
}
