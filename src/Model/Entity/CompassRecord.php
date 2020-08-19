<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Utility\TextSafe;
use Cake\ORM\Entity;

/**
 * CompassRecord Entity
 *
 * @property int $id
 * @property int $document_version_id
 * @property int $membership_number
 * @property string|null $title
 * @property string|null $forenames
 * @property string|null $surname
 * @property string|null $address
 * @property string|null $address_line1
 * @property string|null $address_line2
 * @property string|null $address_line3
 * @property string|null $address_town
 * @property string|null $address_county
 * @property string|null $postcode
 * @property string|null $address_country
 * @property string|null $role
 * @property string|null $location
 * @property string|null $phone
 * @property string|null $email
 *
 * @property \App\Model\Entity\DocumentVersion $document_version
 * @property bool|null $provisional
 * @property string $clean_role
 * @property string $clean_group
 * @property string $clean_section
 * @property null|string $first_name
 * @property string $last_name
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class CompassRecord extends Entity
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
        'document_version_id' => true,
        'membership_number' => true,
        'title' => true,
        'forenames' => true,
        'surname' => true,
        'address' => true,
        'address_line1' => true,
        'address_line2' => true,
        'address_line3' => true,
        'address_town' => true,
        'address_county' => true,
        'postcode' => true,
        'address_country' => true,
        'role' => true,
        'location' => true,
        'phone' => true,
        'email' => true,
        'document_version' => true,
    ];

    /**
     * Prov / PreProv Virtual Field
     *
     * @return bool|null
     */
    protected function _getProvisional(): ?bool
    {
        if (empty($this->role)) {
            return null;
        }

        return !empty(preg_match('/[(](Pre-)*(Prov)[)]/', $this->role));
    }

    /**
     * Cleaned Role
     *
     * @return string
     */
    protected function _getCleanRole(): ?string
    {
        if (empty($this->role)) {
            return null;
        }

        $role = preg_replace('/[(](Pre-)*(Prov)[)]/', '', $this->role);
        $roles = explode(' - ', $role);
        $role = $roles[0];
        $role = trim($role);

        return $role;
    }

    /**
     * Cleaned Group
     *
     * @return string
     */
    protected function _getCleanGroup(): ?string
    {
        if (empty($this->location)) {
            return null;
        }

        $groupArr = explode('@', $this->location);

        if (!empty($groupArr[1])) {
            $group = $groupArr[1];
        } else {
            $group = $groupArr[0];
        }
        $group = trim($group);

        return $group;
    }

    /**
     * Cleaned Section
     *
     * @return string
     */
    protected function _getCleanSection()
    {
        if (empty($this->location)) {
            return null;
        }

        $groupArr = explode('@', $this->location);

        if (!empty($groupArr[1])) {
            $group = $groupArr[1];
        } else {
            $group = $groupArr[0];
        }
        $group = trim($group);

        $sectionArr = explode('@', $this->location);
        $section = $sectionArr[0];
        $section = trim($section);

        $entityMap = [
            'Hertfordshire' => 'County',
            'Bedfordshire' => 'County',
            'Letchworth And Baldock' => 'District',
            'UK Scout Network' => 'Network',
            'Derbyshire' => 'County',
            'Scout Active Support Unit' => 'SAS',
        ];

        if (key_exists($group, $entityMap)) {
            return $entityMap[$group];
        }

        if ($section <> $group) {
            return $section;
        }

        if ($section == $group) {
            return 'Group';
        }

        return null;
    }

    /**
     * Return a First Name Field
     *
     * @return null|string
     */
    protected function _getFirstName(): ?string
    {
        if (empty($this->forenames)) {
            return null;
        }

        $foreNames = explode(' ', $this->forenames);

        return TextSafe::properName($foreNames[0]);
    }

    /**
     * Return a Last Name Field
     *
     * @return string
     */
    protected function _getLastName()
    {
        if (empty($this->surname)) {
            return null;
        }

        return TextSafe::properName($this->surname);
    }

    protected $_virtual = ['provisional', 'clean_role', 'clean_group', 'clean_section', 'first_name', 'last_name'];

    public const FIELD_ID = 'id';
    public const FIELD_DOCUMENT_VERSION_ID = 'document_version_id';
    public const FIELD_MEMBERSHIP_NUMBER = 'membership_number';
    public const FIELD_TITLE = 'title';
    public const FIELD_FORENAMES = 'forenames';
    public const FIELD_SURNAME = 'surname';
    public const FIELD_ADDRESS = 'address';
    public const FIELD_ADDRESS_LINE1 = 'address_line1';
    public const FIELD_ADDRESS_LINE2 = 'address_line2';
    public const FIELD_ADDRESS_LINE3 = 'address_line3';
    public const FIELD_ADDRESS_TOWN = 'address_town';
    public const FIELD_ADDRESS_COUNTY = 'address_county';
    public const FIELD_POSTCODE = 'postcode';
    public const FIELD_ADDRESS_COUNTRY = 'address_country';
    public const FIELD_ROLE = 'role';
    public const FIELD_LOCATION = 'location';
    public const FIELD_PHONE = 'phone';
    public const FIELD_EMAIL = 'email';
    public const FIELD_DOCUMENT_VERSION = 'document_version';
    public const FIELD_PROVISIONAL = 'provisional';
    public const FIELD_CLEAN_ROLE = 'clean_role';
    public const FIELD_CLEAN_GROUP = 'clean_group';
    public const FIELD_CLEAN_SECTION = 'clean_section';
    public const FIELD_FIRST_NAME = 'first_name';
    public const FIELD_LAST_NAME = 'last_name';
}
