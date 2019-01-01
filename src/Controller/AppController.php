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

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

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
//      $this->loadComponent('Cookie');
        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'loginRedirect' => [
                'controller' => 'Pages',
                'action' => 'home'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'authenticate' => [
                'Form',
                //'Xety/Cake3CookieAuth.Cookie'
            ]
        ]);

//      $this->loadComponent('csrf');

//        $this->loadComponent('RequestHandler', [
//            'enableBeforeRedirect' => false,
//        ]);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    /**
     * @param Event $event The CakePHP Event
     *
     * @return \Cake\Http\Response|void|null
     */
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['register']);
        $this->Auth->allow(['login']);
        $this->Auth->allow(['validate']);
        $this->Auth->allow(['reset']);
        $this->Auth->allow(['token']);

//      if (!$this->Auth->user() /*&& $this->Cookie->read('CookieAuth')*/) {
//          $this->loadModel('Users');
//
//          $user = $this->Auth->identify();
//          if ($user) {
//              $this->Auth->setUser($user);
//
//              $user = $this->Users->newEntity($user);
//              $user->isNew(false);
//
//              //Last login date
//              $user->last_login = new Time();
//              //Last login IP
//              $user->last_login_ip = $this->request->clientIp();
//              //etc...
//
//              $this->Users->save($user);
//          } else {
//              $this->Cookie->delete('CookieAuth');
//          }
//      }
    }

    /**
     * Authorisation Check
     *
     * @param User $user The Authorised User
     *
     * @return bool
     */
    public function isAuthorized($user)
    {
        // Admin can access every action
        if (isset($user['authrole']) && $user['authrole'] === 'admin') {
            return true;
        }

        if (isset($user['id'])) {
            if (null !== $this->request->getParam('prefix') && $this->request->getParam('prefix') === 'admin') {
                return false;
            } else {
                return true;
            }
        }

        //The add and index actions are always allowed.
        if (isset($user['id']) && in_array($this->request->getParam('action'), ['index', 'add', 'admin-home'])) {
            return true;
        }

        return false;
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
