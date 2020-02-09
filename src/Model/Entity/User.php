<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\IdentityInterface as AuthenticationIdentity;
use Authorization\IdentityInterface as AuthorizationIdentity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * User Entity
 *
 * @property int $id
 * @property string|null $username
 * @property int $membership_number
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $password
 * @property string|null $address_line_1
 * @property string|null $address_line_2
 * @property string|null $city
 * @property string|null $county
 * @property string|null $postcode
 *
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $last_login
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $last_login_ip
 *
 * @property array|null $capabilities
 *
 * @property string $full_name
 *
 * @property \App\Model\Entity\Audit[] $audits
 * @property \App\Model\Entity\Audit[] $changes
 * @property \App\Model\Entity\CampRole[] $camp_roles
 * @property \App\Model\Entity\Role[] $roles
 * @property \App\Model\Entity\PasswordState|null $password_state
 * @property \App\Model\Entity\EmailSend[] $email_sends
 * @property \App\Model\Entity\Notification[] $notifications
 * @property \App\Model\Entity\UserContact[] $user_contacts
 *
 * @property int|null $password_state_id
 *
 * @property \Authorization\AuthorizationService $authorization
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class User extends Entity implements AuthorizationIdentity, AuthenticationIdentity
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
        'username' => true,
        'membership_number' => true,
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'password' => true,
        'address_line_1' => true,
        'address_line_2' => true,
        'city' => true,
        'county' => true,
        'postcode' => true,
        'created' => true,
        'modified' => true,
        'last_login' => true,
        'last_login_ip' => true,
        'capabilities' => true,
        'password_state_id' => true,
        'changes' => true,
        'audits' => true,
        'camp_roles' => true,
        'roles' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    /**
     * @param string $value The un-hashed password string
     *
     * @return bool|string|void
     */
    protected function _setPassword($value)
    {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($value);
        }
    }

    /**
     * Specifies the method for building up a user's full name.
     *
     * @return string
     */
    protected function _getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Exposed Virtual Properties
     *
     * @var array
     */
    protected $_virtual = ['full_name'];

    /**
     * Authorization\IdentityInterface method
     *
     * {@inheritDoc}
     */
    public function can($action, $resource): bool
    {
        return $this->authorization->can($this, $action, $resource);
    }

    /**
     * Authorization\IdentityInterface method
     *
     * {@inheritDoc}
     */
    public function applyScope($action, $resource)
    {
        return $this->authorization->applyScope($this, $action, $resource);
    }

    /**
     * Authorization\IdentityInterface method
     *
     * {@inheritDoc}
     */
    public function getOriginalData()
    {
        return $this;
    }

    /**
     * Setter to be used by the middleware.
     *
     * @param \Authorization\AuthorizationService $service The Auth Service
     *
     * @return \App\Model\Entity\User
     */
    public function setAuthorization($service)
    {
        $this->authorization = $service;

        return $this;
    }

    /**
     * Authentication\IdentityInterface method
     *
     * @return int
     */
    public function getIdentifier()
    {
        return $this->id;
    }

    /**
     * @param string $action The Action Method
     * @param string $model The Model being Referenced
     * @param int|null $group The Group ID for checking against
     * @param int|null $section The Section ID for checking against
     * @param string|null $field The field for action
     *
     * @return bool
     */
    public function buildAndCheckCapability($action, $model, $group = null, $section = null, $field = null)
    {
        $capTable = TableRegistry::getTableLocator()->get('Capabilities');
        $capability = $capTable->buildCapability($action, $model, $field);

        return $this->checkCapability($capability, $group, $section);
    }

    /**
     * Function to Check Capability Exists
     *
     * @param string $capability The Capability being checked.
     * @param int|null $group A Group ID if applicable
     * @param int|null $section A Section ID if applicable
     *
     * @return bool
     */
    public function checkCapability($capability, $group = null, $section = null)
    {
        if (!is_array($this->capabilities)) {
            return false;
        }

        // User Check
        if (key_exists('user', $this->capabilities)) {
            $capabilities = $this->capabilities['user'];

            if (in_array('ALL', $capabilities)) {
                return true;
            }

            if (in_array($capability, $capabilities)) {
                return true;
            }
        }

        // Group Check
        if ($this->subSetCapabilityCheck($capability, 'group', $group)) {
            return true;
        }

        // Section Check
        if ($this->subSetCapabilityCheck($capability, 'section', $section)) {
            return true;
        }

        return false;
    }

    /**
     * Check for Subset of Capabilities Array.
     *
     * @param string $capability The Capability being Verified
     * @param string $subset The Authorisation Subset
     * @param int $entityID The Entity ID
     *
     * @return bool
     */
    private function subSetCapabilityCheck($capability, $subset, $entityID)
    {
        if (key_exists($subset, $this->capabilities)) {
            $subsetCapabilities = $this->capabilities[$subset];

            if (key_exists($entityID, $subsetCapabilities)) {
                foreach ($subsetCapabilities as $idx => $set) {
                    if (in_array($capability, $set) && $idx == $entityID) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public const FIELD_ID = 'id';
    public const FIELD_USERNAME = 'username';
    public const FIELD_MEMBERSHIP_NUMBER = 'membership_number';
    public const FIELD_FIRST_NAME = 'first_name';
    public const FIELD_LAST_NAME = 'last_name';
    public const FIELD_EMAIL = 'email';
    public const FIELD_PASSWORD = 'password';
    public const FIELD_ADDRESS_LINE_1 = 'address_line_1';
    public const FIELD_ADDRESS_LINE_2 = 'address_line_2';
    public const FIELD_CITY = 'city';
    public const FIELD_COUNTY = 'county';
    public const FIELD_POSTCODE = 'postcode';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_LAST_LOGIN = 'last_login';
    public const FIELD_LAST_LOGIN_IP = 'last_login_ip';
    public const FIELD_CAPABILITIES = 'capabilities';
    public const FIELD_FULL_NAME = 'full_name';
    public const FIELD_AUDITS = 'audits';
    public const FIELD_CHANGES = 'changes';
    public const FIELD_ROLES = 'roles';
    public const FIELD_AUTHORIZATION = 'authorization';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_CAMP_ROLES = 'camp_roles';
    public const FIELD_PASSWORD_STATE = 'password_state';
    public const FIELD_EMAIL_SENDS = 'email_sends';
    public const FIELD_NOTIFICATIONS = 'notifications';
    public const FIELD_USER_CONTACTS = 'user_contacts';
    public const FIELD_PASSWORD_STATE_ID = 'password_state_id';

    public const MINIMUM_PASSWORD_LENGTH = 8;
}
