<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentVersion Entity
 *
 * @property int $id
 * @property int $document_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property int $version_number
 *
 * @property \App\Model\Entity\Document $document
 * @property \App\Model\Entity\DocumentEdition[] $document_editions
 */
class DocumentVersion extends Entity
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
        'document_id' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'version_number' => true,
        'document' => true,
        'document_editions' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_DOCUMENT_ID = 'document_id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_VERSION_NUMBER = 'version_number';
    public const FIELD_DOCUMENT = 'document';
    public const FIELD_DOCUMENT_EDITIONS = 'document_editions';
}
