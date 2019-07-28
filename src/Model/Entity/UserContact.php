<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserContact Entity
 *
 * @property int $id
 * @property string $contact_field
 * @property int $user_id
 * @property int $user_contact_type_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool $verified
 * @property \Cake\I18n\FrozenTime|null $deleted
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Role[] $roles
 * @property \App\Model\Entity\UserContactType $user_contact_type
 */
class UserContact extends Entity
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
        'contact_field' => true,
        'user_id' => true,
        'user_contact_type_id' => true,
        'created' => true,
        'modified' => true,
        'verified' => true,
        'deleted' => true,
        'user' => true,
        'roles' => true
    ];
}
