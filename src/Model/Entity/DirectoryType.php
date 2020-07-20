<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DirectoryType Entity
 *
 * @property int $id
 * @property string $directory_type
 * @property string $directory_type_code
 *
 * @property \App\Model\Entity\Directory[] $directories
 */
class DirectoryType extends Entity
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
        'directory_type' => true,
        'directory_type_code' => true,
        'directories' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_DIRECTORY_TYPE = 'directory_type';
    public const FIELD_DIRECTORY_TYPE_CODE = 'directory_type_code';
    public const FIELD_DIRECTORIES = 'directories';
}
