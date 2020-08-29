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
 * @property bool|null $new
 * @property string|null $notification_header
 * @property string|null $text
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $read_date
 * @property string|null $notification_source
 * @property int|null $link_id
 * @property string|null $link_controller
 * @property string|null $link_prefix
 * @property string|null $link_action
 * @property \Cake\I18n\FrozenTime|null $deleted
 *
 * @property \App\Model\Entity\User|null $user
 * @property \App\Model\Entity\NotificationType|null $notification_type
 * @property \App\Model\Entity\EmailSend[] $email_sends
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
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
    protected $_accessible = [
        'user_id' => true,
        'notification_type_id' => true,
        'new' => true,
        'notification_header' => true,
        'text' => true,
        'created' => true,
        'read_date' => true,
        'notification_source' => true,
        'link_id' => true,
        'link_controller' => true,
        'link_prefix' => true,
        'link_action' => true,
        'deleted' => true,
        'user' => true,
        'notification_type' => true,
        'email_sends' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_NOTIFICATION_TYPE_ID = 'notification_type_id';
    public const FIELD_NEW = 'new';
    public const FIELD_NOTIFICATION_HEADER = 'notification_header';
    public const FIELD_TEXT = 'text';
    public const FIELD_CREATED = 'created';
    public const FIELD_READ_DATE = 'read_date';
    public const FIELD_NOTIFICATION_SOURCE = 'notification_source';
    public const FIELD_LINK_ID = 'link_id';
    public const FIELD_LINK_CONTROLLER = 'link_controller';
    public const FIELD_LINK_PREFIX = 'link_prefix';
    public const FIELD_LINK_ACTION = 'link_action';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_USER = 'user';
    public const FIELD_NOTIFICATION_TYPE = 'notification_type';
    public const FIELD_EMAIL_SENDS = 'email_sends';
}
