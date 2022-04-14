<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @since         3.7.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\Utility\Inflector;

/**
 * A trait intended to make application tests of your controllers easier.
 */
trait AppTestTrait
{
    use IntegrationTestTrait;

    /**
     * Function to log user in for authentication
     *
     * @param int $userId User ID for login Function
     */
    protected function login(int $userId = 1): void
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->get($userId);

        // Add the Capabilities retrieval method
        $users->patchCapabilities($user);
        $user = $users->get($userId);

        $this->session(['Auth' => $user]);
    }

    /**
     * Function to do generic feature for Get Integration Test Load.
     *
     * @param array|string $url The Url Array to be tested.
     * @return void
     */
    protected function tryGet($url): void
    {
        $this->login();
        $this->get($url);
        $this->assertResponseOk();
    }

    /**
     * Function to encapsulate Basic Index Get Tests.
     *
     * @param string $controller The Controller for Indexing
     */
    protected function tryIndexGet(string $controller): void
    {
        $this->tryGet(['controller' => $controller, 'action' => 'index']);
    }

    /**
     * Function to encapsulate Basic Index Get Tests.
     *
     * @param string $controller The Controller being searched
     * @param string|null $searchString The String being searched for
     */
    protected function trySearchGet(string $controller, ?string $searchString): void
    {
        $this->tryGet(['controller' => $controller, 'action' => 'search']);

        $this->tryGet(['controller' => $controller, 'action' => 'search', '?' => ['q' => $searchString]]);
    }

    /**
     * Function to encapsulate Basic Index Get Tests.
     *
     * @param string $controller The Controller for the View Object
     */
    protected function tryViewGet(string $controller): void
    {
        $this->tryGet(['controller' => $controller, 'action' => 'view', 1]);
    }

    /**
     * Function to encapsulate Basic Index Get Tests.
     *
     * @param string $controller
     */
    protected function tryAddGet(string $controller): void
    {
        $this->tryGet(['controller' => $controller, 'action' => 'add']);
    }

    /**
     * Function to encapsulate Basic Index Get Tests.
     *
     * @param string $controller
     */
    protected function tryEditGet(string $controller): void
    {
        $this->tryGet(['controller' => $controller, 'action' => 'edit', 1]);
    }

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

        $this->post($url, $validData);

        $this->assertRedirect();
        $this->assertRedirect($expectedRedirect);
    }

    /**
     * @param array $url The Url Array to be tested.
     * @param array $validData Valid data for the Entity.
     * @param array $expectedRedirect Expected Redirect URL.
     * @param string $expectedMessage
     */
    protected function tryFlashPost(
        array $url,
        array $validData,
        array $expectedRedirect,
        string $expectedMessage
    ): void {
        $this->tryPost($url, $validData, $expectedRedirect);

        $this->assertFlashElement('flash/success');
        $this->assertFlashMessage($expectedMessage);
    }

    /**
     * Function to encapsulate Basic Add Post Tests.
     *
     * @param string $controller Name of the Controller being Interrogated.
     * @param array $validData Array of Valid Data.
     * @param int $newEntityId Id for next Entity.
     * @param array|null $expectedRedirect Array to Redirect to.
     * @param string|null $expectedMessage Override Message
     */
    protected function tryAddPost(
        string $controller,
        array $validData,
        int $newEntityId,
        ?array $expectedRedirect = null,
        ?string $expectedMessage = null
    ): void {
        $url = [
            'controller' => $controller,
            'action' => 'add',
        ];
        $expectedRedirect = $this->getRedirect($expectedRedirect, 'add', [
            'controller' => $controller,
            'action' => 'view',
            $newEntityId,
        ]);
        $message = $this->getMessage('add', $controller, $expectedMessage);
        $this->tryFlashPost($url, $validData, $expectedRedirect, $message);
    }

    /**
     * Function to encapsulate Basic Edit Post Tests.
     *
     * @param string $controller Name of the Controller being Interrogated.
     * @param array $validData Array of Valid Data.
     * @param int $entityId Id for next Entity.
     * @param array|null $expectedRedirect Redirect Array after Edit
     * @param string|null $expectedMessage Flash Message Expected
     */
    protected function tryEditPost(
        string $controller,
        array $validData,
        int $entityId,
        ?array $expectedRedirect = null,
        ?string $expectedMessage = null
    ): void {
        $url = [
            'controller' => $controller,
            'action' => 'edit',
            $entityId,
        ];
        $expectedRedirect = $expectedRedirect ?? [
            'controller' => $controller,
            'action' => 'view',
            $entityId,
        ];
        $message = $this->getMessage('edit', $controller, $expectedMessage);
        $this->tryFlashPost($url, $validData, $expectedRedirect, $message);
    }

    /**
     * Function to encapsulate Basic Add Post Tests.
     *
     * @param string $controller Name of the Controller being Interrogated.
     * @param array|null $validData Array of Valid Data.
     * @param int $newEntityId Id for next Entity.
     * @param array|null $expectedRedirects Redirect Array or Array of Redirects with Action Keys.
     * @param array|null $expectedMessages Array of Expected Flash Messages
     */
    protected function tryDeletePost(
        string $controller,
        ?array $validData,
        int $newEntityId,
        ?array $expectedRedirects = null,
        ?array $expectedMessages = null
    ): void {
        if (is_array($validData) && !empty($validData)) {
            $message = null;
            if (is_array($expectedMessages) && key_exists('add', $expectedMessages)) {
                $message = $expectedMessages['add'];
            }
            $this->tryAddPost($controller, $validData, $newEntityId, $expectedRedirects, $message);
        }

        $url = [
            'controller' => $controller,
            'action' => 'delete',
            $newEntityId,
        ];

        $redirect = $this->getRedirect($expectedRedirects, 'delete', [
            'controller' => $controller,
            'action' => 'index',
        ]);

        $this->tryPost($url, [], $redirect);

        $url['action'] = 'view';
        $this->login();
        $this->get($url);
        $this->assertResponseCode(404);
    }

    /**
     * @param array|null $redirectArray The Redirect Array for Parsing
     * @param string $action The Action for Processing
     * @param array $default The Default Return if array not set
     * @return array
     */
    private function getRedirect(?array $redirectArray, string $action, array $default): array
    {
        if (is_null($redirectArray)) {
            return $default;
        }

        if (key_exists('action', $redirectArray)) {
            return $redirectArray;
        }

        return $redirectArray[$action] ?? $default;
    }

    /**
     * @param string $action The Action for Processing
     * @param string $controller The Controller
     * @param string|null $expectedMessage Override Message
     * @return string|null
     */
    private function getMessage(string $action, string $controller, ?string $expectedMessage = null): ?string
    {
        $verb = 'saved';
        if ($action == 'delete') {
            $verb = 'deleted';
        }

        $entity = strtolower(Inflector::singularize(Inflector::humanize(Inflector::underscore($controller))));

        return $expectedMessage ?? 'The ' . $entity . ' has been ' . $verb . '.';
    }
}
