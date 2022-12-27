<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Test\Fixture\FixtureTestTrait;
use App\Utility\CapBuilder;
use Authorization\Exception\AuthorizationRequiredException;
use Cake\Core\Configure;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\Utility\Inflector;
use PHPUnit\Exception;

/**
 * Trait PolicyTestTrait A trait designed to simplify policy testing.
 *
 * @package App\Test\TestCase\Policy
 */
trait PolicyTestTrait
{
    use IntegrationTestTrait;
    use FixtureTestTrait;
    use LocatorAwareTrait;

    protected function setupForbiddenError(): void
    {
        Configure::write('UnauthorizedExceptions', [
            'Authorization\Exception\MissingIdentityException',
            // Does not contain the 'Authorization\Exception\ForbiddenException' in Capabilities
        ]);
    }

    /**
     * @return User
     */
    private function getFakeUser(): User
    {
        $userTestData = [
            'username' => 'Test123',
            'membership_number' => (int)89809,
            'first_name' => 'Juliet',
            'last_name' => 'Bravo',
            'email' => 'jules@bravo.org.uk',
            'password' => '$2y$10$6xl1gLHZyHzNfciVdoFLy.7TZAdt77yb/bStDdLBfLbjtGaDp3Nqm',
            'address_line_1' => '5 Gatterson',
            'address_line_2' => '',
            'city' => 'Goat Land',
            'county' => 'Lingua',
            'postcode' => 'LI6 9PP',
            'last_login' => null,
            'deleted' => null,
            'last_login_ip' => 'null',
            'capabilities' => [
                'user' => ['BLAH-NOT-A-REAL-KEY'],
                'group' => [
                    1 => ['BLAH-NOT-A-REAL-KEY'],
                    9 => ['BLAH-NOT-A-REAL-KEY'],
                ],
                'section' => [
                    4 => ['BLAH-NOT-A-REAL-KEY'],
                    8 => ['BLAH-NOT-A-REAL-KEY'],
                ],
            ],
            'user_state_id' => null,
            'full_name' => 'Juliet Bravo',
        ];

        $user = new User($userTestData, ['validate' => false]);
        $user->setNew(false);

        return $user;
    }

    /**
     * @param string $capability Capability the User will have
     */
    protected function userWithUserCapability(string $capability): void
    {
        $this->userWithCapability($capability, 'user');
    }

    /**
     * @param string $capability Capability the User will have
     * @param string $level Capability Level
     */
    protected function userWithCapability(string $capability, string $level = 'user'): void
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->find()->first();

        if (empty($user) || is_null($user)) {
            $user = $this->getFakeUser();
        }

        // Add the Capabilities retrieval method
        $user->set('capabilities', [$level => [$capability]]);
        $user->clean();

        $this->session(['Auth' => $user]);
    }

    /**
     * @param string|array $capability Capability the User will have
     */
    protected function userWithOutCapability($capability)
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->find()->first();

        if (empty($user) || is_null($user)) {
            $user = $this->getFakeUser();
        }

        $capabilities = $user->get('capabilities');
        if (empty($capabilities) || is_null($capabilities)) {
            $capabilities = $this->getFakeUser()->capabilities;
        }

        if (is_array($capability)) {
            foreach ($capability as $cap) {
                $capabilities = $this->popCapability($capabilities, $cap);
            }
        } else {
            $capabilities = $this->popCapability($capabilities, 'BLAH-NOT-A-REAL-KEY');
        }

        $user->set('capabilities', $capabilities);
        $user->clean();

        $this->session(['Auth' => $user]);
    }

    /**
     * @param array $capabilityArray Array of User's Capabilities
     * @param string $capability Capability Key
     * @return array
     */
    private function popCapability(array $capabilityArray, string $capability): array
    {
        if (in_array($capability, $capabilityArray['user']) !== false) {
            foreach ($capabilityArray['user'] as $key => $value) {
                if ($value == $capability) {
                    unset($capabilityArray['user'][$key]);
                }
            }
        }

        foreach (array_keys($capabilityArray['group']) as $groupKey) {
            if (
                is_array($capabilityArray['group'][$groupKey]) &&
                in_array($capability, $capabilityArray['group'][$groupKey]) !== false
            ) {
                foreach ($capabilityArray['group'][$groupKey] as $key => $value) {
                    if ($value == $capability) {
                        unset($capabilityArray['group'][$groupKey][$key]);
                    }
                }
            }
        }

        foreach (array_keys($capabilityArray['section']) as $groupKey) {
            if (
                is_array($capabilityArray['section'][$groupKey]) &&
                in_array($capability, $capabilityArray['section'][$groupKey]) !== false
            ) {
                foreach ($capabilityArray['section'][$groupKey] as $key => $value) {
                    if ($value == $capability) {
                        unset($capabilityArray['section'][$groupKey][$key]);
                    }
                }
            }
        }

        return $capabilityArray;
    }

    /**
     * Function to do generic feature for Get Integration Test Load.
     *
     * @param array|string $url The Url Array to be tested.
     * @param string|null $capability The Capability to be checked
     * @return void
     */
    protected function tryGetWith($url, $capability = null)
    {
        $this->setupForbiddenError();

        if (is_null($capability) && is_array($url)) {
            if (key_exists('action', $url) && key_exists('controller', $url)) {
                $capability = CapBuilder::capabilityCodeFormat($url['action'], $url['controller']);
            }
        }

        $this->userWithUserCapability($capability);

        try {
            $this->get($url);
        } catch (Exception $e) {
            assertTrue(false, 'Exception Emitted for GET Request.');
        }

        $this->assertResponseOk();
    }

    /**
     * Function to do generic feature for Get Integration Test Load.
     *
     * @param array|string $url The Url Array to be tested.
     * @param array|string|null $capability The Capability to be checked
     * @return void
     */
    protected function tryGetWithout($url, $capability = null)
    {
        $this->setupForbiddenError();

        if (is_null($capability) && is_array($url)) {
            if (key_exists('action', $url) && key_exists('controller', $url)) {
                $capability = CapBuilder::capabilityCodeFormat($url['action'], $url['controller']);
            }
        }

        $this->userWithOutCapability($capability);

        try {
            $this->get($url);
        } catch (Exception $e) {
            assertTrue(false, 'Exception Emitted for GET Request.');
        }

        $this->assertResponseError();
    }

    /**
     * Function to encapsulate Basic Index Get Tests.
     *
     * @param string $controller Name of the Controller
     * @param string|null $capability Capability being tested
     */
    protected function tryIndexWith($controller, $capability = null)
    {
        $this->tryGetWith(['controller' => $controller, 'action' => 'index'], $capability);
    }

    /**
     * Function to encapsulate Basic Index Get Tests.
     *
     * @param string $controller Name of the Controller
     * @param array|string|null $capability Capability being tested
     */
    protected function tryIndexWithout($controller, $capability = null)
    {
        $this->tryGetWithout(['controller' => $controller, 'action' => 'index'], $capability);
    }

    /**
     * Function to encapsulate Basic Index Get Tests.
     *
     * @param string $controller Controller
     * @param null $capability Non Default Capability
     */
    protected function tryViewWith($controller, $capability = null)
    {
        $this->tryGetWith(['controller' => $controller, 'action' => 'view', 1], $capability);
    }

    /**
     * Function to encapsulate Basic Index Get Tests.
     *
     * @param string $controller Controller
     * @param array|string|null $capability Non default Capability
     */
    protected function tryViewWithout($controller, $capability = null)
    {
        $this->tryGetWithout(['controller' => $controller, 'action' => 'view', 1], $capability);
    }

//    /**
//     * Function to encapsulate Basic Index Get Tests.
//     *
//     * @param $controller
//     */
//    protected function tryAddGet($controller)
//    {
//        $this->tryGet(['controller' => $controller, 'action' => 'add']);
//    }
//
//    /**
//     * Function to encapsulate Basic Index Get Tests.
//     *
//     * @param $controller
//     */
//    protected function tryEditGet($controller)
//    {
//        $this->tryGet(['controller' => $controller, 'action' => 'edit', 1]);
//    }

    /**
     * @param array $url The Url Array to be tested.
     * @param array $validData Data valid for the Method.
     * @param array $expectedRedirect The Url Array expected to be redirected.
     */
    protected function tryPost(array $url, array $validData, array $expectedRedirect): void
    {
        $this->login();

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();

        try {
            $this->post($url, $validData);
        } catch (AuthorizationRequiredException $exception) {
            assertTrue(false, 'Exception Emitted for POST Request.');
        }

        $this->assertRedirect();
        $this->assertRedirect($expectedRedirect);
    }

    /**
     * @param array $url The Url Array to be tested.
     * @param array $validData Valid data for the Entity.
     * @param array $expectedRedirect Expected Redirect URL.
     */
    protected function tryFlashPost(array $url, array $validData, array $expectedRedirect): void
    {
        $this->tryPost($url, $validData, $expectedRedirect);

        $this->assertFlashElement('Flash/success');

        $verb = 'saved';
        if ($url['action'] == 'delete') {
            $verb = 'deleted';
        }

        $entity = strtolower(Inflector::singularize(Inflector::humanize(Inflector::underscore($url['controller']))));
        $successMessage = 'The ' . $entity . ' has been ' . $verb . '.';
        $this->assertFlashMessage($successMessage);
    }

    /**
     * Function to encapsulate Basic Add Post Tests.
     *
     * @param string $controller Name of the Controller being Interrogated.
     * @param array $validData Array of Valid Data.
     * @param int $newEntityId Id for next Entity.
     */
    protected function tryAddPost($controller, $validData, $newEntityId)
    {
        $url = [
            'controller' => $controller,
            'action' => 'add',
        ];
        $expectedRedirect = [
            'controller' => $controller,
            'action' => 'view',
            $newEntityId,
        ];

        $this->tryFlashPost($url, $validData, $expectedRedirect);
    }

    /**
     * Function to encapsulate Basic Edit Post Tests.
     *
     * @param string $controller Name of the Controller being Interrogated.
     * @param array $validData Array of Valid Data.
     * @param int $entityId Id for next Entity.
     */
    protected function tryEditPost(string $controller, array $validData, int $entityId): void
    {
        $url = [
            'controller' => $controller,
            'action' => 'edit',
            $entityId,
        ];
        $expectedRedirect = [
            'controller' => $controller,
            'action' => 'view',
            $entityId,
        ];

        $this->tryFlashPost($url, $validData, $expectedRedirect);
    }

    /**
     * Function to encapsulate Basic Add Post Tests.
     *
     * @param string $controller Name of the Controller being Interrogated.
     * @param array $validData Array of Valid Data.
     * @param int $newEntityId Id for next Entity.
     */
    protected function tryDeletePost(string $controller, array $validData, int $newEntityId): void
    {
        $this->tryAddPost($controller, $validData, $newEntityId);

        $url = [
            'controller' => $controller,
            'action' => 'delete',
            $newEntityId,
        ];
        $expectedRedirect = [
            'controller' => $controller,
            'action' => 'index',
        ];

        $this->tryFlashPost($url, $validData, $expectedRedirect);
    }
}
