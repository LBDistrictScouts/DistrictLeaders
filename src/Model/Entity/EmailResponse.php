<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailResponse Entity
 *
 * @property int $id
 * @property int $email_send_id
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property int $email_response_type_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $received
 * @property string|null $link_clicked
 * @property string|null $ip_address
 * @property string|null $bounce_reason
 * @property int|null $message_size
 *
 * @property \App\Model\Entity\EmailSend $email_send
 * @property \App\Model\Entity\EmailResponseType $email_response_type
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
        'email_response_type' => true
    ];
}
