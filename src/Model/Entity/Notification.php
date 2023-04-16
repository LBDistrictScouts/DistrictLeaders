<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Notification Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $notification_type_id
 * @property string $notification_header
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $read_date
 * @property string|null $notification_source
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property array $body_content
 * @property array|null $subject_link
 * @property string|null $email_code
 *
 * @property \App\Model\Entity\User|null $user
 * @property \App\Model\Entity\NotificationType|null $notification_type
 * @property \App\Model\Entity\EmailSend[] $email_sends
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @property bool $new
 * @property string|null $text
 * @property string|null $link_id
 * @property string|null $link_controller
 * @property string|null $link_prefix
 * @property string|null $link_action
 */
class Notification extends Entity
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
    protected array $_accessible = [
        'user_id' => true,
        'notification_type_id' => true,
        'notification_header' => true,
        'created' => true,
        'read_date' => true,
        'notification_source' => true,
        'deleted' => true,
        'body_content' => true,
        'subject_link' => true,
        'user' => true,
        'notification_type' => true,
        'email_sends' => true,
    ];

    /**
     * Specifies the method for building up a user's full name.
     *
     * @return string|null
     */
    protected function _getEmailCode(): ?string
    {
        if (!$this->has('notification_type')) {
            return null;
        }

        return $this->notification_type->type . '-' . $this->user_id . '-' . $this->notification_type->sub_type;
    }

    protected array $_virtual = [
        'email_code',
    ];

    protected array $_hidden = [
        'new',
        'text',
        'link_id',
        'link_controller',
        'link_prefix',
        'link_action',
    ];

    public const FIELD_ID = 'id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_NOTIFICATION_TYPE_ID = 'notification_type_id';
    public const FIELD_NOTIFICATION_HEADER = 'notification_header';
    public const FIELD_CREATED = 'created';
    public const FIELD_READ_DATE = 'read_date';
    public const FIELD_NOTIFICATION_SOURCE = 'notification_source';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_BODY_CONTENT = 'body_content';
    public const FIELD_SUBJECT_LINK = 'subject_link';
    public const FIELD_USER = 'user';
    public const FIELD_NOTIFICATION_TYPE = 'notification_type';
    public const FIELD_EMAIL_SENDS = 'email_sends';
    public const FIELD_EMAIL_CODE = 'email_code';
    public const FIELD_NEW = 'new';
    public const FIELD_TEXT = 'text';
    public const FIELD_LINK_ID = 'link_id';
    public const FIELD_LINK_CONTROLLER = 'link_controller';
    public const FIELD_LINK_PREFIX = 'link_prefix';
    public const FIELD_LINK_ACTION = 'link_action';
}
