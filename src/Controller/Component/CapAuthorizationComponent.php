<?php
namespace App\Controller\Component;

use Authorization\Controller\Component\AuthorizationComponent;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * CapAuthorization component
 *
 * {@inheritDoc}
 */
class CapAuthorizationComponent extends AuthorizationComponent
{
    /**
     * @var \App\Model\Entity\User
     */
    protected $capUser;

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config)
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

        foreach ($resource->getVisible() as $visibleField) {
            if ($this->buildAndCheckCapability($action, 'Users', $group, $section, $visibleField)) {
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
     * @return bool|\Authorization\Policy\ResultInterface
     */
    public function buildAndCheckCapability($action, $model, $group = null, $section = null, $field = null)
    {
        return $this->capUser->buildAndCheckCapability($action, $model, $group, $section, $field);
    }

    /**
     * @return \App\Model\Entity\User
     */
    protected function getCapUser()
    {
        $request = $this->getController()->getRequest();
        $identity = $this->getIdentity($request);

        $users = TableRegistry::getTableLocator()->get('Users');

        return $users->get($identity['id']);
    }
}
