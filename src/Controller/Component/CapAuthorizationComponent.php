<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\User;
use Authorization\Controller\Component\AuthorizationComponent;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ModelAwareTrait;

/**
 * {@inheritDoc}
 *
 * CapAuthorization component
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Controller\AppController getController()
 */
class CapAuthorizationComponent extends AuthorizationComponent
{
    use ModelAwareTrait;

    /**
     * @var \App\Model\Entity\User
     */
    protected User $capUser;

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
    private array $alwaysPermitted = [
        User::FIELD_ID,
        User::FIELD_CAPABILITIES,
    ];

    /**
     * @param \Cake\Datasource\EntityInterface $resource The resource to check authorization on.
     * @param string|null $action The action to check authorization for.
     * @return array
     */
    public function see(EntityInterface $resource, ?string $action = 'VIEW'): array
    {
        $fields = [];

        $resourceFields = $this->getResourceFields($resource);

        if ($resource instanceof User && $resource->id == $this->capUser->id) {
            return [];
        }

        foreach ($resourceFields as $visibleField) {
            if (in_array($visibleField, $resource->getVirtual()) || in_array($visibleField, $this->alwaysPermitted)) {
                continue;
            }
            if (preg_match('/(_id)/', $visibleField)) {
                continue;
            }
            if (
                !$this->buildAndCheckCapability(
                    $action,
                    $resource->getSource(),
                    $this->getGroups($resource),
                    $this->getSections($resource),
                    $visibleField
                )
            ) {
                array_push($fields, $visibleField);
            }
        }

        return $fields;
    }

    /**
     * @param \Cake\Datasource\EntityInterface $resource ORM Resource
     * @return array
     */
    protected function getResourceFields(EntityInterface $resource): array
    {
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

        return $resourceFields;
    }

    /**
     * @param \Cake\Datasource\EntityInterface $resource ORM Resource
     * @return array
     */
    protected function getGroups(EntityInterface $resource): ?array
    {
        $groups = null;

        if ($resource instanceof User) {
            $groups = $resource->groups;
        }

        return $groups;
    }

    /**
     * @param \Cake\Datasource\EntityInterface $resource ORM Resource
     * @return array
     */
    protected function getSections(EntityInterface $resource): ?array
    {
        $sections = null;

        if ($resource instanceof User) {
            $sections = $resource->sections;
        }

        return $sections;
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
    public function checkCapability(string $capability, ?int $group = null, ?int $section = null): bool
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
    public function checkCapabilityResult(string $capability, ?int $group = null, ?int $section = null): ResultInterface
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
        string $action,
        string $model,
        ?int $group = null,
        ?int $section = null,
        ?string $field = null
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
    public function buildAndCheckCapability(
        string $action,
        string $model,
        array|int|null $group = null,
        array|int|null $section = null,
        ?string $field = null
    ): bool {
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
