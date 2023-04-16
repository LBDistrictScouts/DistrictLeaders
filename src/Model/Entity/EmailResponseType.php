<?php
declare(strict_types=1);

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
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
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
    protected array $_accessible = [
        'email_response_type' => true,
        'bounce' => true,
        'email_responses' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_EMAIL_RESPONSE_TYPE = 'email_response_type';
    public const FIELD_BOUNCE = 'bounce';
    public const FIELD_EMAIL_RESPONSES = 'email_responses';
}
