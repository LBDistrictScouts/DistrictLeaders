<?php
declare(strict_types=1);

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

use App\Listener\CapabilityListener;
use App\Listener\RoleListener;
use App\Listener\TokenListener;
use App\Listener\UserListener;
use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Table;
use Muffin\Footprint\Auth\FootprintAwareTrait;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 *
 * @property \Flash\Controller\Component\FlashComponent $Flash
 * @property \App\Controller\Component\CapAuthorizationComponent $Authorization.Authorization
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
     * @return bool|\Cake\ORM\Entity
     */
    protected function _setCurrentUser($user = null): ?EntityInterface
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
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     * @throws \Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');

        $this->loadComponent('Flash');

        $this->loadComponent('Authorization.Authorization', ['className' => 'CapAuthorization']);

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);

        $this->eventListeners();
    }

    /**
     * @param \Cake\ORM\Table $model Table to be authenticated with credentials.
     * @return void
     */
    public function whyPermitted(Table $model)
    {
        $result = $this->Authorization->canResult($model);
        $this->set('PolicyResult', $result);
    }

    /**
     * Function to attach Event Listeners
     *
     * @return void
     */
    private function eventListeners()
    {
        $this->getEventManager()->on(new TokenListener());
        $this->getEventManager()->on(new RoleListener());
        $this->getEventManager()->on(new CapabilityListener());
        $this->getEventManager()->on(new UserListener());
    }
}
