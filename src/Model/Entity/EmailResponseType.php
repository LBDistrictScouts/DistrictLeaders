<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailResponseType Entity
 *
 * @property int $id
 * @property string|null $email_response_type
 * @property bool $bounce
 *
 * @property \App\Model\Entity\EmailResponse[] $email_responses
 */
class EmailResponseType extends Entity
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
        'email_response_type' => true,
        'bounce' => true,
        'email_responses' => true
    ];
}
