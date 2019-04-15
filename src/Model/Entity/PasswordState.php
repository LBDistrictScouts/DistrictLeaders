<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PasswordState Entity
 *
 * @property int $id
 * @property string $password_state
 * @property bool $active
 * @property bool $expired
 *
 * @property \App\Model\Entity\User[] $users
 */
class PasswordState extends Entity
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
        'password_state' => true,
        'active' => true,
        'expired' => true,
        'users' => true
    ];
}
