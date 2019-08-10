<?php
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
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\NotificationType $notification_type
 * @property \App\Model\Entity\Link $link
 * @property \App\Model\Entity\EmailSend[] $email_sends
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
        'link' => true,
        'email_sends' => true
    ];
}
