<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FileType Entity
 *
 * @property int $id
 * @property string $file_type
 * @property string $file_extension
 * @property string|null $mime
 *
 * @property \App\Model\Entity\DocumentEdition[] $document_editions
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class FileType extends Entity
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
        'file_type' => true,
        'file_extension' => true,
        'mime' => true,
        'document_editions' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_FILE_TYPE = 'file_type';
    public const FIELD_FILE_EXTENSION = 'file_extension';
    public const FIELD_DOCUMENT_EDITIONS = 'document_editions';
    public const FIELD_MIME = 'mime';
}
