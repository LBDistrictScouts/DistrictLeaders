<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Token Entity
 *
 * @property int $id
 * @property string $token
 * @property int $email_send_id
 * @property FrozenTime|null $created
 * @property FrozenTime|null $modified
 * @property FrozenTime|null $expires
 * @property FrozenTime|null $utilised
 * @property bool $active
 * @property FrozenTime|null $deleted
 * @property string|null $hash
 * @property int|null $random_number
 * @property array|null $token_header
 *
 * @property EmailSend $email_send
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Token extends Entity
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
        'token' => true,
        'email_send_id' => true,
        'created' => true,
        'modified' => true,
        'expires' => true,
        'utilised' => true,
        'active' => true,
        'deleted' => true,
        'hash' => true,
        'random_number' => true,
        'token_header' => true,
        'email_send' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'hash', 'token',
    ];

    public const FIELD_ID = 'id';
    public const FIELD_TOKEN = 'token';
    public const FIELD_EMAIL_SEND_ID = 'email_send_id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_EXPIRES = 'expires';
    public const FIELD_UTILISED = 'utilised';
    public const FIELD_ACTIVE = 'active';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_HASH = 'hash';
    public const FIELD_RANDOM_NUMBER = 'random_number';
    public const FIELD_TOKEN_HEADER = 'token_header';
    public const FIELD_EMAIL_SEND = 'email_send';
}
