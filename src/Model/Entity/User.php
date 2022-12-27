<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Utility\CapBuilder;
use Authentication\IdentityInterface as AuthenticationIdentityInterface;
use Authorization\AuthorizationService;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;
use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;

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
 * @property FrozenTime $created
 * @property FrozenTime|null $modified
 * @property FrozenTime|null $last_login
 * @property FrozenTime|null $deleted
 * @property string|null $last_login_ip
 *
 * @property array|null $capabilities
 *
 * @property int|null $user_state_id
 *
 * @property bool $cognito_enabled
 * @property bool $receive_emails
 * @property bool $activated
 *
 * @property int|null $all_role_count
 * @property int|null $active_role_count
 * @property int|null $all_email_count
 * @property int|null $all_phone_count
 * @property int|null $validated_email_count
 * @property int|null $validated_phone_count
 *
 * @property string $full_name
 *
 * @property array|null $groups
 * @property array|null $sections
 *
 * @property UserState|null $user_state
 * @property Audit[] $changes
 * @property Audit[] $audits
 * @property CampRole[] $camp_roles
 * @property EmailSend[] $email_sends
 * @property Notification[] $notifications
 * @property Role[] $roles
 * @property UserContact[] $user_contacts
 * @property UserContact[] $contact_emails
 * @property UserContact[] $contact_numbers
 * @property DirectoryUser[] $directory_users
 *
 * @property AuthorizationService $authorization
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @property string|null $search_string
 * @property int $tag_count
 */
class User extends Entity implements IdentityInterface, AuthenticationIdentityInterface
{
    use LocatorAwareTrait;

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
        'user_state_id' => true,
        'cognito_enabled' => true,
        'all_role_count' => true,
        'active_role_count' => true,
        'all_email_count' => true,
        'all_phone_count' => true,
        'receive_emails' => true,
        'user_state' => true,
        'changes' => true,
        'audits' => true,
        'camp_roles' => true,
        'email_sends' => true,
        'notifications' => true,
        'roles' => true,
        'user_contacts' => true,
        'contact_emails' => true,
        'contact_numbers' => true,
        'directory_users' => true,
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
    protected $_virtual = ['full_name', 'sections', 'groups'];

    private $userKey = self::CAP_KEY_USER;
    private $groupKey = self::CAP_KEY_GROUP;
    private $sectionKey = self::CAP_KEY_SECTION;

    /**
     * Authorization\IdentityInterface method
     *
     * @param string $action The action/operation being performed.
     * @param mixed $resource The resource being operated on.
     * @return bool
     */
    public function can($action, $resource): bool
    {
        return $this->authorization->can($this, $action, $resource);
    }

    /**
     * Authorization\IdentityInterface method
     *
     * @param string $action The action/operation being performed.
     * @param mixed $resource The resource being operated on.
     * @return ResultInterface
     */
    public function canResult(string $action, $resource): ResultInterface
    {
        return $this->authorization->canResult($this, $action, $resource);
    }

    /**
     * Authorization\IdentityInterface method
     *
     * @param string $action The action/operation being performed.
     * @param mixed $resource The resource being operated on.
     * @return mixed The modified resource.
     */
    public function applyScope($action, $resource)
    {
        return $this->authorization->applyScope($this, $action, $resource);
    }

    /**
     * Authorization\IdentityInterface method
     *
     * @return self
     */
    public function getOriginalData(): User
    {
        return $this;
    }

    /**
     * Setter to be used by the middleware.
     *
     * @param AuthorizationService $service The Auth Service
     * @return self
     */
    public function setAuthorization(AuthorizationService $service): User
    {
        $this->authorization = $service;

        return $this;
    }

    /**
     * Authentication\IdentityInterface method
     *
     * @return int
     */
    public function getIdentifier(): int
    {
        return $this->id;
    }

    /**
     * returns an array of User's Groups
     *
     * @return array|null
     */
    protected function _getGroups(): ?array
    {
        if (is_array($this->capabilities) && key_exists($this->groupKey, $this->capabilities)) {
            return array_keys($this->capabilities[$this->groupKey]);
        }

        return null;
    }

    /**
     * returns an array of User's Sections
     *
     * @return array|null
     */
    protected function _getSections(): ?array
    {
        if (is_array($this->capabilities) && key_exists($this->sectionKey, $this->capabilities)) {
            return array_keys($this->capabilities[$this->sectionKey]);
        }

        return null;
    }

    /**
     * @param string $action The Action Method
     * @param string $model The Model being Referenced
     * @param int|array|null $group The Group ID for checking against
     * @param int|array|null $section The Section ID for checking against
     * @param string|null $field The field for action
     * @return bool
     */
    public function buildAndCheckCapability(
        string $action,
        string $model,
        $group = null,
        $section = null,
        $field = null
    ): bool {
        return $this->buildAndCheckCapabilityResult($action, $model, $group, $section, $field)->getStatus();
    }

    /**
     * @param string $action The Action Method
     * @param string $model The Model being Referenced
     * @param int|array|null $group The Group ID for checking against
     * @param int|array|null $section The Section ID for checking against
     * @param string|null $field The field for action
     * @return ResultInterface
     */
    public function buildAndCheckCapabilityResult(
        string $action,
        string $model,
        $group = null,
        $section = null,
        ?string $field = null
    ): ResultInterface {
        if (!CapBuilder::isActionType($action)) {
            return new Result(false, 'Action Supplied is Invalid.');
        }

        $capability = CapBuilder::capabilityCodeFormat($action, $model, $field);

        return $this->checkCapabilityResult($capability, $group, $section);
    }

    /**
     * Function to Check Capability Exists
     *
     * @param string $capability The Capability being checked.
     * @param int|array|null $group A Group ID if applicable
     * @param int|array|null $section A Section ID if applicable
     * @return bool
     */
    public function checkCapability(string $capability, $group = null, $section = null): bool
    {
        return $this->checkCapabilityResult($capability, $group, $section)->getStatus();
    }

    /**
     * Function to Check Capability Exists
     *
     * @param string $capability The Capability being checked.
     * @param int|array|null $group A Group ID if applicable
     * @param int|array|null $section A Section ID if applicable
     * @return ResultInterface
     */
    public function checkCapabilityResult(string $capability, $group = null, $section = null): ResultInterface
    {
        if (!is_array($this->capabilities)) {
            return new Result(false, 'Array Not String Passed.');
        }

        // User Check
        if (key_exists('user', $this->capabilities)) {
            $capabilities = $this->capabilities[$this->userKey];

            if (in_array('ALL', $capabilities)) {
                return new Result(true, 'Admin Capability Found.');
            }

            if (in_array($capability, $capabilities)) {
                return new Result(true, 'Capability Found in User.');
            }
        }

        // Group Check
        if ($this->subSetCapabilityCheck($capability, $this->groupKey, $group)) {
            return new Result(true, 'Capability Found in Group.');
        }

        // Section Check
        if ($this->subSetCapabilityCheck($capability, $this->sectionKey, $section)) {
            return new Result(true, 'Capability Found in Section.');
        }

        return new Result(false, 'No Valid Capability Found.');
    }

    /**
     * Check for Subset of Capabilities Array.
     *
     * @param string $capability The Capability being verified
     * @param string $subset The Authorisation Subset
     * @param int $entities The Entity ID or Array of IDs
     * @return bool
     */
    private function subSetCapabilityCheck($capability, $subset, $entities): bool
    {
        if (key_exists($subset, $this->capabilities)) {
            $subsetCapabilities = $this->capabilities[$subset];

            if (is_integer($entities) && $this->capabilitySubsetArray($capability, $entities, $subsetCapabilities)) {
                return true;
            }

            if (is_array($entities)) {
                foreach ($entities as $entity) {
                    if ($this->capabilitySubsetArray($capability, $entity, $subsetCapabilities)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param string $capability The Capability being verified
     * @param int $entityID The Entity ID
     * @param array $subsetCapabilities The Capabilities for the level being checked
     * @return bool
     */
    private function capabilitySubsetArray($capability, $entityID, $subsetCapabilities)
    {
        if (key_exists($entityID, $subsetCapabilities)) {
            foreach ($subsetCapabilities as $idx => $set) {
                if (in_array($capability, $set) && $idx == $entityID) {
                    return true;
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
    public const FIELD_GROUPS = 'groups';
    public const FIELD_SECTIONS = 'sections';
    public const FIELD_AUDITS = 'audits';
    public const FIELD_CHANGES = 'changes';
    public const FIELD_ROLES = 'roles';
    public const FIELD_AUTHORIZATION = 'authorization';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_CAMP_ROLES = 'camp_roles';
    public const FIELD_USER_STATE = 'user_state';
    public const FIELD_EMAIL_SENDS = 'email_sends';
    public const FIELD_NOTIFICATIONS = 'notifications';
    public const FIELD_USER_CONTACTS = 'user_contacts';
    public const FIELD_USER_STATE_ID = 'user_state_id';
    public const FIELD_PASSWORD_STATE = 'password_state';
    public const FIELD_COGNITO_ENABLED = 'cognito_enabled';
    public const FIELD_DIRECTORY_USERS = 'directory_users';
    public const FIELD_RECEIVE_EMAILS = 'receive_emails';
    public const FIELD_ALL_ROLE_COUNT = 'all_role_count';
    public const FIELD_ACTIVE_ROLE_COUNT = 'active_role_count';
    public const FIELD_ALL_EMAIL_COUNT = 'all_email_count';
    public const FIELD_ALL_PHONE_COUNT = 'all_phone_count';
    public const FIELD_CONTACT_EMAILS = 'contact_emails';
    public const FIELD_CONTACT_NUMBERS = 'contact_numbers';
    public const FIELD_VALIDATED_EMAIL_COUNT = 'validated_email_count';
    public const FIELD_VALIDATED_PHONE_COUNT = 'validated_phone_count';
    public const FIELD_ACTIVATED = 'activated';
    public const FIELD_SEARCH_STRING = 'search_string';
    public const FIELD_TAG_COUNT = 'tag_count';

    public const MINIMUM_PASSWORD_LENGTH = 8;

    public const CAP_KEY_USER = 'user';
    public const CAP_KEY_GROUP = 'group';
    public const CAP_KEY_SECTION = 'section';
}
