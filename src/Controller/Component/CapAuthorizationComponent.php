<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Authorization\Controller\Component\AuthorizationComponent;
use Cake\Datasource\ModelAwareTrait;

/**
 * CapAuthorization component
 *
 * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        if (!isset($this->capUser)) {
            $this->capUser = $this->getCapUser();
        }
    }

    /**
     * @param \Cake\ORM\Entity $resource The resource to check authorization on.
     * @param string|null $action The action to check authorization for.
     *
     * @return array
     *
     * @throws \Authorization\Exception\ForbiddenException when policy check fails.
     */
    public function see($resource, $action = 'VIEW')
    {
        $fields = [];

        $group = null;
        $section = null;

        $virtual = $resource->getVirtual();

        foreach ($resource->getVisible() as $visibleField) {
            if (in_array($visibleField, $virtual)) {
                continue;
            }
            if ($this->buildAndCheckCapability($action, $resource->getSource(), $group, $section, $visibleField)) {
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
     *
     * @return bool|\Authorization\Policy\ResultInterface
     */
    public function checkCapability($capability, $group = null, $section = null)
    {
        if (is_null($this->CapUser)) {
            return false;
        }

        return $this->capUser->checkCapability($capability, $group, $section);
    }

    /**
     * Check the policy for $resource, returns true if the action is allowed
     *
     * If $action is left undefined, the current controller action will
     * be used.
     *
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
        if (is_null($this->capUser)) {
            return false;
        }

        return $this->capUser->buildAndCheckCapability($action, $model, $group, $section, $field);
    }

    /**
     * @return \App\Model\Entity\User|null
     */
    protected function getCapUser()
    {
        $request = $this->getController()->getRequest();
        $identity = $this->getIdentity($request);

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
