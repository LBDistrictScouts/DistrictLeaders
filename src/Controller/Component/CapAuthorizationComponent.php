<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\User;
use Authorization\Controller\Component\AuthorizationComponent;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;
use Cake\Datasource\ModelAwareTrait;

/**
 * {@inheritDoc}
 *
 * CapAuthorization component
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class CapAuthorizationComponent extends AuthorizationComponent
{
    use ModelAwareTrait;

    /**
     * @var \App\Model\Entity\User
     */
    protected $capUser;

    /**
     * @inheritDoc
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        if (!isset($this->capUser)) {
            $this->capUser = $this->getCapUser();
        }
    }

    /**
     * @var array The Array for Permissions which shouldn't be blocked
     */
    private $alwaysPermitted = [
        User::FIELD_ID,
        User::FIELD_CAPABILITIES,
    ];

    /**
     * @param \Cake\ORM\Entity $resource The resource to check authorization on.
     * @param string|null $action The action to check authorization for.
     * @return array
     * @throws \Authorization\Exception\ForbiddenException when policy check fails.
     */
    public function see($resource, $action = 'VIEW')
    {
        $fields = [];

        $groups = null;
        $sections = null;

        if ($resource instanceof User) {
            $groups = $resource->groups;
            $sections = $resource->sections;
        }

        $virtual = $resource->getVirtual();
        $resourceFields = $resource->getVisible();

        foreach (array_keys($resource->getAccessible()) as $accessible) {
            if (!in_array($accessible, $resourceFields)) {
                array_push($resourceFields, $accessible);
            }
        }

        foreach ($virtual as $vValue) {
            unset($resourceFields[array_search($vValue, $resourceFields)]);
        }

        if ($resource instanceof User && $resource->id == $this->capUser->id) {
            return $resourceFields;
        }

        foreach ($resourceFields as $visibleField) {
            if (in_array($visibleField, $virtual) || in_array($visibleField, $this->alwaysPermitted)) {
                continue;
            }
            if (!$this->buildAndCheckCapability($action, $resource->getSource(), $groups, $sections, $visibleField)) {
                array_push($fields, $visibleField);
            }
        }

        return $fields;
    }

    /**
     * Check the policy for $resource, returns true if the action is allowed
     *
     * If $action is left undefined, the current controller action will
     * be used.
     *
     * @param string $capability The Capability being checked.
     * @param int|null $group A Group ID if applicable
     * @param int|null $section A Section ID if applicable
     * @return bool
     */
    public function checkCapability($capability, $group = null, $section = null)
    {
        return $this->checkCapabilityResult($capability, $group, $section)->getStatus();
    }

    /**
     * Check the policy for $resource, returns true if the action is allowed
     *
     * If $action is left undefined, the current controller action will
     * be used.
     *
     * @param string $capability The Capability being checked.
     * @param int|null $group A Group ID if applicable
     * @param int|null $section A Section ID if applicable
     * @return \Authorization\Policy\ResultInterface
     */
    public function checkCapabilityResult($capability, $group = null, $section = null)
    {
        if (is_null($this->capUser)) {
            return new Result(false, 'Component User Null.');
        }

        return $this->capUser->checkCapabilityResult($capability, $group, $section);
    }

    /**
     * Check the policy for $resource, returns true if the action is allowed
     *
     * If $action is left undefined, the current controller action will
     * be used.
     *
     * @param string $action The Action Method
     * @param string $model The Model being Referenced
     * @param array|int|null $group The Group ID for checking against
     * @param array|int|null $section The Section ID for checking against
     * @param string|null $field The field for action
     * @return \Authorization\Policy\ResultInterface
     */
    public function buildAndCheckCapabilityResult(
        $action,
        $model,
        $group = null,
        $section = null,
        $field = null
    ): ResultInterface {
        if (is_null($this->capUser)) {
            return new Result(false, 'Component User Null.');
        }

        return $this->capUser->buildAndCheckCapabilityResult($action, $model, $group, $section, $field);
    }

    /**
     * Check the policy for $resource, returns true if the action is allowed
     *
     * If $action is left undefined, the current controller action will
     * be used.
     *
     * @param string $action The Action Method
     * @param string $model The Model being Referenced
     * @param array|int|null $group The Group ID for checking against
     * @param array|int|null $section The Section ID for checking against
     * @param string|null $field The field for action
     * @return bool
     */
    public function buildAndCheckCapability($action, $model, $group = null, $section = null, $field = null): bool
    {
        return $this->buildAndCheckCapabilityResult($action, $model, $group, $section, $field)->getStatus();
    }

    /**
     * @return \App\Model\Entity\User|null
     */
    protected function getCapUser(): ?User
    {
        $request = $this->getController()->getRequest();
        /** @var \App\Model\Entity\User $identity */
        $identity = $this->getIdentity($request);

        if ($identity instanceof IdentityInterface) {
            return $identity->getOriginalData();
        }

        if (is_null($identity)) {
            return null;
        }

        if (is_integer($identity['id'])) {
            $this->loadModel('Users');

            return $this->Users->get($identity['id']);
        }

        return null;
    }
}
