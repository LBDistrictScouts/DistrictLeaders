<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;
use Josbeir\Filesystem\FileEntityInterface;
use Josbeir\Filesystem\FilesystemAwareTrait;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;

/**
 * DocumentEdition Entity
 *
 * @property int $id
 * @property FrozenTime $created
 * @property FrozenTime|null $modified
 * @property FrozenTime|null $deleted
 * @property int $document_version_id
 * @property int $file_type_id
 * @property string|null $file_path
 * @property string|null $filename
 * @property int|null $size
 * @property string|null $md5_hash
 *
 * @property DocumentVersion $document_version
 * @property FileType $file_type
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class DocumentEdition extends Entity implements FileEntityInterface
{
    use FilesystemAwareTrait;

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
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'document_version_id' => true,
        'file_type_id' => true,
        'file_path' => true,
        'filename' => true,
        'size' => true,
        'md5_hash' => true,
        'document_version' => true,
        'file_type' => true,
    ];

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->file_path ?? $this->get('path');
    }

    /**
     * @param string $path The Path to be set
     * @return FileEntityInterface
     */
    public function setPath(string $path): FileEntityInterface
    {
        $this->set($this::FIELD_FILE_PATH, $path);

        return $this;
    }

    /**
     * @return string|false
     */
    public function read()
    {
        /** @var Filesystem $fileSystem */
        $fileSystem = $this->getFilesystem();

        try {
            return $fileSystem->read($this->getPath());
        } catch (FileNotFoundException $e) {
            return false;
        }
    }

    public const FIELD_ID = 'id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_DOCUMENT_VERSION_ID = 'document_version_id';
    public const FIELD_FILE_TYPE_ID = 'file_type_id';
    public const FIELD_DOCUMENT_VERSION = 'document_version';
    public const FIELD_FILE_TYPE = 'file_type';
    public const FIELD_MD5_HASH = 'md5_hash';
    public const FIELD_FILE_PATH = 'file_path';
    public const FIELD_FILENAME = 'filename';
    public const FIELD_SIZE = 'size';
}
