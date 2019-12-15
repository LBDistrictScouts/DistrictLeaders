<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Listener\RoleListener;
use App\Listener\UserListener;
use Authentication\AuthenticationService;
use Cake\Controller\Controller;
use Muffin\Footprint\Auth\FootprintAwareTrait;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 * @property \Flash\Controller\Component\FlashComponent $Flash
 */
class AppController extends Controller
{
    use FootprintAwareTrait {
        _setCurrentUser as _footprintSetCurrentUser;
    }

    /**
     * The override code to configure Footprint Aware Audits for use with the Authentication Plugin
     *
     * @param null $user The Footprint User
     *
     * @return bool|\Cake\ORM\Entity
     */
    protected function _setCurrentUser($user = null)
    {
        if (!$user) {
            $user = $this->request->getAttribute('identity');

            if (is_null($user)) {
                return null;
            }

            $user = $user->getOriginalData();
        }

        return $this->_footprintSetCurrentUser($user);
    }

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     *
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');

        // Instantiate the service
        $service = new AuthenticationService();

        // Load identifiers
        $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                'username' => 'username',
                'password' => 'password',
            ],
        ]);

        // Load the authenticators
        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form');

        $this->loadComponent('Flash.Flash');
        $this->loadComponent('Cookie');

        $this->loadComponent('Authorization.Authorization');

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);

        $this->eventListeners();
    }

    /**
     * Function to attach Event Listeners
     *
     * @return void
     */
    private function eventListeners()
    {
        $this->getEventManager()->on(new UserListener());
        $this->getEventManager()->on(new RoleListener());
    }
}
