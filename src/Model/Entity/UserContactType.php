<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * UserContactType Entity
 *
 * @property int $id
 * @property string $user_contact_type
 * @property FrozenTime $created
 * @property FrozenTime|null $modified
 *
 * @property UserContact[] $user_contacts
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class UserContactType extends Entity
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
        'user_contact_type' => true,
        'created' => true,
        'modified' => true,
        'user_contacts' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_USER_CONTACT_TYPE = 'user_contact_type';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_USER_CONTACTS = 'user_contacts';
}
