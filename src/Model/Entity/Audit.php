<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Audit Entity
 *
 * @property int $id
 * @property string $audit_field
 * @property string $audit_table
 * @property string|null $original_value
 * @property string $modified_value
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime $change_date
 *
 * @property \App\Model\Entity\User $user
 */
class Audit extends Entity
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
        'audit_field' => true,
        'audit_table' => true,
        'original_value' => true,
        'modified_value' => true,
        'user_id' => true,
        'change_date' => true,
        'user' => true
    ];
}
