<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailSend Entity
 *
 * @property int $id
 * @property string|null $email_generation_code
 * @property string|null $email_template
 * @property bool $include_token
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property \Cake\I18n\FrozenTime|null $sent
 * @property string|null $message_send_code
 * @property int|null $user_id
 * @property string|null $subject
 * @property string|null $routing_domain
 * @property string|null $from_address
 * @property string|null $friendly_from
 * @property int|null $notification_id
 *
 * @property \App\Model\Entity\User|null $user
 * @property \App\Model\Entity\Notification|null $notification
 * @property \App\Model\Entity\EmailResponse[] $email_responses
 * @property \App\Model\Entity\Token[] $tokens
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class EmailSend extends Entity
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
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $_accessible = [
        'email_generation_code' => true,
        'email_template' => true,
        'include_token' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'sent' => true,
        'message_send_code' => true,
        'user_id' => true,
        'subject' => true,
        'routing_domain' => true,
        'from_address' => true,
        'friendly_from' => true,
        'notification_id' => true,
        'user' => true,
        'notification' => true,
        'email_responses' => true,
        'tokens' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_EMAIL_GENERATION_CODE = 'email_generation_code';
    public const FIELD_EMAIL_TEMPLATE = 'email_template';
    public const FIELD_INCLUDE_TOKEN = 'include_token';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_SENT = 'sent';
    public const FIELD_MESSAGE_SEND_CODE = 'message_send_code';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_SUBJECT = 'subject';
    public const FIELD_ROUTING_DOMAIN = 'routing_domain';
    public const FIELD_FROM_ADDRESS = 'from_address';
    public const FIELD_FRIENDLY_FROM = 'friendly_from';
    public const FIELD_NOTIFICATION_ID = 'notification_id';
    public const FIELD_USER = 'user';
    public const FIELD_NOTIFICATION = 'notification';
    public const FIELD_EMAIL_RESPONSES = 'email_responses';
    public const FIELD_TOKENS = 'tokens';
}
