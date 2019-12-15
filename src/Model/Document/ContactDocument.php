<?php
namespace App\Model\Document;

use Cake\ElasticSearch\Document;

/**
 * Class ContactDocument
 *
 * @package App\Model\Document
 */
class ContactDocument extends Document
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
        'membership_number' => true,
        'first_name' => true,
        'last_name' => true,
        'full_name' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_MEMBERSHIP_NUMBER = 'membership_number';
    public const FIELD_FIRST_NAME = 'first_name';
    public const FIELD_LAST_NAME = 'last_name';
    public const FIELD_FULL_NAME = 'full_name';
}
