<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CampType Entity
 *
 * @property int $id
 * @property string $camp_type
 *
 * @property Camp[] $camps
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class CampType extends Entity
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
        'camp_type' => true,
        'camps' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_CAMP_TYPE = 'camp_type';
    public const FIELD_CAMPS = 'camps';
}
