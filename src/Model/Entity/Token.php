<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Token Entity
 *
 * @property int $id
 * @property string $token
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $expires
 * @property \Cake\I18n\FrozenTime|null $utilised
 * @property bool $active
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $hash
 * @property int|null $random_number
 * @property array|null $token_header
 * @property int $email_send_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\EmailSend $email_send
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
        'created' => true,
        'modified' => true,
        'expires' => true,
        'utilised' => true,
        'active' => true,
        'deleted' => true,
        'hash' => true,
        'random_number' => true,
        'token_header' => true,
        'email_send_id' => true,
        'user' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token'
    ];
}
