<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property int $membership_number
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string|null $address_line_1
 * @property string|null $address_line_2
 * @property string|null $city
 * @property string|null $county
 * @property string|null $postcode
 * @property int|null $admin_scout_group_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $last_login
 *
 * @property \App\Model\Entity\ScoutGroup $scout_group
 * @property \App\Model\Entity\Audit[] $audits
 * @property \App\Model\Entity\Role[] $roles
 */
class User extends Entity
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
        'username' => true,
        'membership_number' => true,
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'password' => true,
        'address_line_1' => true,
        'address_line_2' => true,
        'city' => true,
        'county' => true,
        'postcode' => true,
        'admin_scout_group_id' => true,
        'created' => true,
        'modified' => true,
        'last_login' => true,
        'scout_group' => true,
        'audits' => true,
        'roles' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
