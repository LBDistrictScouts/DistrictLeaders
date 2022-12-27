<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Document Entity
 *
 * @property int $id
 * @property int $document_type_id
 * @property FrozenTime $created
 * @property FrozenTime|null $modified
 * @property FrozenTime|null $deleted
 * @property string $document
 *
 * @property int|null $document_preview_id
 * @property int|null $latest_version
 *
 * @property DocumentType $document_type
 * @property DocumentVersion[] $document_versions
 * @property DocumentEdition|null $document_preview
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Document extends Entity
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
        'document_type_id' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'document' => true,
        'document_type' => true,
        'document_versions' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_DOCUMENT_TYPE_ID = 'document_type_id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_DOCUMENT = 'document';
    public const FIELD_DOCUMENT_TYPE = 'document_type';
    public const FIELD_DOCUMENT_VERSIONS = 'document_versions';
    public const FIELD_DOCUMENT_PREVIEW_ID = 'document_preview_id';
    public const FIELD_LATEST_VERSION = 'latest_version';
    public const FIELD_DOCUMENT_PREVIEW = 'document_preview';
}
