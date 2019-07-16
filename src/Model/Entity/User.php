<?php
namespace App\Model\Entity;

use Authorization\AuthorizationServiceInterface;
use Authorization\IdentityInterface;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

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
 *
 * @property \Authorization\AuthorizationService $authorization
 */
class User extends Entity implements IdentityInterface
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
        'scout_group' => true,
        'audits' => true,
        'roles' => true,
        'capabilities' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
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
    public function can($action, $resource)
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
    public const FIELD_ADMIN_SCOUT_GROUP_ID = 'admin_scout_group_id';
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
}
