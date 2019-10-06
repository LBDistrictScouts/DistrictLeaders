<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\PasswordForm;
use App\Form\ResetForm;
use App\Model\Entity\User;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method User[]|ResultSetInterface paginate($object = null, array $settings = [])
 *
 * @property \App\Model\Table\TokensTable $Tokens
 */
class UsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $visibleFields = [
            'id',
            'first_name',
            'last_name',
            'email',
        ];

        $user = $this->Users->get($id, [
            'contain' => ['Audits.Users', 'Changes.ChangedUsers', 'Roles'],
            'fields' => $visibleFields,
        ]);

        $this->Authorization->can($user, 'view');

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'view', $user->get('id')]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|void If Successful - redirects to landing.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function login()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('landing');

        $result = $this->Authentication->getResult();

        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $event = new Event('Model.User.login', $this, [
                'user' => $this->request->getAttribute('identity')->getOriginalData()
            ]);
            $this->getEventManager()->dispatch($event);

            $redirect = $this->request->getQuery('redirect', ['controller' => 'Pages', 'action' => 'display', 'home']);

            return $this->redirect($redirect);
        }

        // display error if user submitted and authentication failed
        if ($this->request->is(['post']) && !$result->isValid()) {
            $this->Flash->error('Invalid username or password');
        }
    }

    /**
     * Logout Function
     *
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $logout = $this->Authentication->logout();

        if ($logout != false) {
            $this->Flash->success('You are now logged out.');

            return $this->redirect($logout);
        }

        return $this->redirect($this->referer(['controller' => 'Pages', 'action' => 'display', 'home']));
    }

    /**
     * Password Reset Function - Enables Resetting a User's Password via Email
     *
     * @return \Cake\Http\Response
     *
     * @throws \Exception
     */
    public function forgot()
    {
        $this->viewBuilder()->setLayout('landing');

        $resForm = new ResetForm();

        $session = $this->request->getSession();

        $this->set(compact('resForm'));

        if ($this->request->is('post')) {
            if ($session->check('Reset.rsTries')) {
                $tries = $session->read('Reset.rsTries');
            }

            if (!isset($tries)) {
                $tries = 0;
            }

            if (isset($tries) && $tries < 6) {
                // Extract Form Info
                $fmMembership = $this->request->getData('membership_number');
                $fmEmail = $this->request->getData('email');

                $found = $this->Users->find('all')
                                     ->where(['email' => $fmEmail, 'membership_number' => $fmMembership]);

                $count = $found->count();
                $user = $found->first();

                $tries += 1;
                $session->write('Reset.rsTries', $tries);

                if ($count == 1) {
                    // Success in Resetting Triggering Reset - Bouncing to Reset.
                    $session->delete('Reset.lgTries');
                    $session->delete('Reset.rsTries');

                    $this->loadComponent('Password');

                    if ($this->Password->sendReset($user->id)) {
                        $this->Flash->success('We have sent a password reset token to your email. This is valid for a short period of time.');

                        return $this->redirect(['prefix' => false, 'controller' => 'Landing', 'action' => 'welcome']);
                    }

                    $this->Flash->error(__('The user could not be saved. Please, try again.'));

                    $this->log('Token Creation Error during Password Reset for user ' . $user->id, 'notice');
                } else {
                    $this->Flash->error('This user was not found in the system.');
                }
            } else {
                $this->Flash->error('You have failed entry too many times. Please try again later.');

                return $this->redirect(['prefix' => false, 'controller' => 'Landing', 'action' => 'welcome']);
            }
        }
    }

    /**
     * Username Clarification Function - Enables Resetting a User's Password via Email
     *
     * @return void
     *
     * @throws \Exception
     */
    public function username()
    {
        $this->viewBuilder()->setLayout('landing');

        $resForm = new ResetForm();
        $this->set(compact('resForm'));

        if ($this->request->is('post')) {
            $found = $this
                ->Users
                ->find('all')
                ->where([
                    'membership_number' => $this->request->getData('membership_number'),
                    'first_name' => $this->request->getData('first_name'),
                    'last_name' => $this->request->getData('last_name')
                ]);

            $count = $found->count();
            $user = $found->first();

            if ($count == 1) {
                $this->set('username', $user->username);
            } else {
                $this->Flash->error('This user was not found in the system.');
            }
        }
    }

    protected const CHANGE_TYPE_UNAUTHORIZED = 0;
    protected const CHANGE_TYPE_RESET = 1;
    protected const CHANGE_TYPE_UPDATE = 2;

    /**
     * Token - Completes Password Reset Function
     *
     * @param string $token The String to Be Validated
     *
     * @return \Cake\Http\Response|void
     */
    public function password($token = null)
    {
        $changeType = self::CHANGE_TYPE_UNAUTHORIZED;
        $this->viewBuilder()->setLayout('outside');
        $this->loadModel('Tokens');

        $valid = $this->Tokens->validateToken($token);
        if (!$valid) {
            $changeType = self::CHANGE_TYPE_RESET;
            /** @var \App\Model\Entity\Token $tokenRow */
            $tokenRow = $this->Tokens->get($valid, ['contain' => 'EmailSends.Users']);
            $resetUser = $tokenRow->email_send->user;
        }

        $identity = $this->Authentication->getIdentity();
        if (is_null($identity)) {
            $changeType = self::CHANGE_TYPE_UPDATE;
            $resetUser = $identity;
        }

        if ($changeType == self::CHANGE_TYPE_UNAUTHORIZED) {
            $this->Flash->error('Password Reset Token could not be validated.');

            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        if ($changeType > self::CHANGE_TYPE_UNAUTHORIZED && isset($resetUser) && $resetUser instanceof User) {
            $passwordForm = new PasswordForm();
            $this->set(compact('passwordForm'));

            if ($this->request->is('post')) {
                $fmPassword = $this->request->getData('newpw');
                $fmConfirm = $this->request->getData('confirm');

                if ($fmConfirm == $fmPassword) {
                    $fmPostcode = str_replace(" ", "", strtoupper($this->request->getData('postcode')));
                    $usPostcode = str_replace(" ", "", strtoupper($resetUser->postcode));

                    if ($usPostcode == $fmPostcode) {
                        $newPw = [
                            'password' => $fmPassword,
                            'reset' => 'No Longer Active'
                        ];

                        $resetUser = $this->Users->patchEntity($resetUser, $newPw, [ 'fields' => ['password'], 'validate' => false ]);

                        if ($this->Users->save($resetUser)) {
                            $this->Flash->success('Your password was saved successfully.');

                            return $this->redirect(['prefix' => false, 'controller' => 'Users', 'action' => 'login']);
                        } else {
                            $this->Flash->error(__('The user could not be saved. Please try again.'));
                        }
                    } else {
                        $this->Flash->error(__('Your postcode could not be validated. Please try again.'));
                    }
                } else {
                    $this->Flash->error(__('The passwords you have entered do not match. Please try again.'));
                }
            }
        }
    }

    /**
     * @param Event $event The CakePHP Event
     *
     * @return \Cake\Http\Response|void|null
     */
    public function beforeFilter(Event $event)
    {
        $this->Authentication->allowUnauthenticated(['login', 'username', 'forgot', 'token', 'password']);
    }
}
