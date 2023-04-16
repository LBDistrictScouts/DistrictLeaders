<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DirectoryDomain Entity
 *
 * @property int $id
 * @property string $directory_domain
 * @property int $directory_id
 * @property bool $ingest
 *
 * @property \App\Model\Entity\Directory $directory
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class DirectoryDomain extends Entity
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
        self::FIELD_DIRECTORY_DOMAIN => true,
        self::FIELD_DIRECTORY_ID => true,
        self::FIELD_INGEST => true,
        self::FIELD_DIRECTORY => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_DIRECTORY_DOMAIN = 'directory_domain';
    public const FIELD_DIRECTORY_ID = 'directory_id';
    public const FIELD_INGEST = 'ingest';
    public const FIELD_DIRECTORY = 'directory';
}
