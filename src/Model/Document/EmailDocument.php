<?php
declare(strict_types=1);

namespace App\Model\Document;

use Cake\ElasticSearch\Document;

/**
 * Class EmailDocument
 *
 * @package App\Model\Document
 */
class EmailDocument extends Document
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
        'id' => true,
        'user' => true,
        'email' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_USER = 'user';
    public const FIELD_EMAIL = 'first_name';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
}
