<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * EmailResponse Entity
 *
 * @property int $id
 * @property int $email_send_id
 * @property FrozenTime|null $deleted
 * @property int $email_response_type_id
 * @property FrozenTime|null $created
 * @property FrozenTime|null $received
 * @property string|null $link_clicked
 * @property string|null $ip_address
 * @property string|null $bounce_reason
 * @property int|null $message_size
 *
 * @property EmailSend $email_send
 * @property EmailResponseType $email_response_type
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class EmailResponse extends Entity
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
        'email_send_id' => true,
        'deleted' => true,
        'email_response_type_id' => true,
        'created' => true,
        'received' => true,
        'link_clicked' => true,
        'ip_address' => true,
        'bounce_reason' => true,
        'message_size' => true,
        'email_send' => true,
        'email_response_type' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_EMAIL_SEND_ID = 'email_send_id';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_EMAIL_RESPONSE_TYPE_ID = 'email_response_type_id';
    public const FIELD_CREATED = 'created';
    public const FIELD_RECEIVED = 'received';
    public const FIELD_LINK_CLICKED = 'link_clicked';
    public const FIELD_IP_ADDRESS = 'ip_address';
    public const FIELD_BOUNCE_REASON = 'bounce_reason';
    public const FIELD_MESSAGE_SIZE = 'message_size';
    public const FIELD_EMAIL_SEND = 'email_send';
    public const FIELD_EMAIL_RESPONSE_TYPE = 'email_response_type';
}
