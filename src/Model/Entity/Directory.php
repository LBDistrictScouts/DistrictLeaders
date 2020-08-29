<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Directory Entity
 *
 * @property int $id
 * @property string $directory
 * @property array|null $configuration_payload
 * @property int $directory_type_id
 * @property bool $active
 * @property string|null $customer_reference
 * @property array|null $authorisation_token
 *
 * @property \App\Model\Entity\DirectoryType $directory_type
 * @property \App\Model\Entity\DirectoryDomain[] $directory_domains
 * @property \App\Model\Entity\DirectoryGroup[] $directory_groups
 * @property \App\Model\Entity\DirectoryUser[] $directory_users
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Directory extends Entity
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
        'directory' => true,
        'configuration_payload' => true,
        'directory_type_id' => true,
        'active' => true,
        'customer_reference' => true,
        'authorisation_token' => false,
        'directory_type' => true,
        'directory_domains' => true,
        'directory_groups' => true,
        'directory_users' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'authorisation_token',
    ];

    public const FIELD_ID = 'id';
    public const FIELD_DIRECTORY = 'directory';
    public const FIELD_DIRECTORY_TYPE_ID = 'directory_type_id';
    public const FIELD_ACTIVE = 'active';
    public const FIELD_CUSTOMER_REFERENCE = 'customer_reference';
    public const FIELD_AUTHORISATION_TOKEN = 'authorisation_token';
    public const FIELD_DIRECTORY_TYPE = 'directory_type';
    public const FIELD_DIRECTORY_DOMAINS = 'directory_domains';
    public const FIELD_DIRECTORY_GROUPS = 'directory_groups';
    public const FIELD_DIRECTORY_USERS = 'directory_users';
    public const FIELD_CONFIGURATION_PAYLOAD = 'configuration_payload';
}
