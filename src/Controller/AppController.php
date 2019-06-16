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

use App\Model\Entity\User;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Time;
use Muffin\Footprint\Auth\FootprintAwareTrait;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    use FootprintAwareTrait;

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

        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');

        $this->loadComponent('Authorization.Authorization');

//        $this->loadComponent('Auth', [
//            'authenticate' => [
//                'Form' => [
//                    'fields' => [
//                        'username' => 'username',
//                        'password' => 'password'
//                    ],
//                    'finder' => 'auth',
//                ],
//                'Xety/Cake3CookieAuth.Cookie',
//            ],
//            'loginAction' => [
//                'controller' => 'Users',
//                'action' => 'login'
//            ],
//            'loginRedirect' => [
//                'controller' => 'Pages',
//                'action' => 'home'
//            ],
//            'logoutRedirect' => [
//                'controller' => 'Users',
//                'action' => 'login'
//            ],
//            //use isAuthorized in Controllers
//            'authorize' => ['Controller'],
//            // If unauthorized, return them to page they were just on
//            'unauthorizedRedirect' => $this->referer()
//        ]);
//
//        // Allow the display action so our PagesController
//        // continues to work. Also enable the read only actions.
//        $this->Auth->allow(['display']);

//      $this->loadComponent('csrf');

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');

//        if (null !== $this->Auth->user()) {
//            $this->set('loggedInUserId', $this->Auth->user('id'));
//        }
    }

    /**
     * @param Event $event The CakePHP Event
     *
     * @return \Cake\Http\Response|void|null
     */
//    public function beforeFilter(Event $event)
//    {
//        if (!$this->Auth->user() && $this->Cookie->read('CookieAuth')) {
//            $user = $this->Auth->identify();
//            if ($user) {
//                $this->loadModel('Users');
//                $user = $this->Users->get($user['id']);
//
//                //Last login date
//                $user->last_login = new Time();
//                //Last login IP
//                $user->last_login_ip = $this->request->clientIp();
//
//                $this->Users->patchCapabilities($user);
//
//                $this->Auth->setUser($user);
//            } else {
//                $this->Cookie->delete('CookieAuth');
//            }
//        }
//    }

    /**
     * Authorisation Check
     *
     * @param User $user The Authorised User
     *
     * @return bool
     */
    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * Logout Function
     *
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $session = $this->request->getSession();
        $session->delete('OSM.Secret');

        $this->Flash->success('You are now logged out.');

        return $this->redirect($this->Auth->logout());
    }
}
