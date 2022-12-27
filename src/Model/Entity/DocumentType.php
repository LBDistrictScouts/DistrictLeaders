<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentType Entity
 *
 * @property int $id
 * @property string $document_type
 * @property string|null $special_capability
 *
 * @property Document[] $documents
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class DocumentType extends Entity
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
        'document_type' => true,
        'special_capability' => true,
        'documents' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_DOCUMENT_TYPE = 'document_type';
    public const FIELD_SPECIAL_CAPABILITY = 'special_capability';
    public const FIELD_DOCUMENTS = 'documents';
}
