<?php
declare(strict_types=1);

namespace App\Controller;

use App\Authenticator\CognitoResult;
use App\Form\PasswordForm;
use App\Form\ResetForm;
use App\Model\Entity\Audit;
use App\Model\Entity\Token;
use App\Model\Entity\User;
use App\Model\Filter\UsersCollection;
use Authorization\Policy\ResultInterface;
use Cake\Event\Event;
use Cake\ORM\Query;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 * @property \App\Model\Table\TokensTable $Tokens
 * @property \App\Model\Table\EmailSendsTable $EmailSends
 * @property \App\Controller\Component\GoogleClientComponent $GoogleClient
 */
class UsersController extends AppController
{
    /**
     * @throws \Exception
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->Authentication->allowUnauthenticated(['login', 'username', 'forgot', 'token', 'welcome']);

        $this->Authorization->mapActions([
            'search' => 'index',
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->Authorization->authorize($this->Users);

        /** @var \App\Model\Entity\User $user */
        $user = $this->request->getAttribute('identity')->getOriginalData();

        if (!$user->checkCapability('DIRECTORY')) {
            $this->Flash->error('Results limited due to user permissions.');
        }

        $query = $this->Users->find();
        $users = $this->paginate($this->Authorization->applyScope($query));
        $this->set(compact('users'));

        $this->whyPermitted($this->Users);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function search()
    {
        $this->Authorization->authorize($this->Users);

        /** @var \App\Model\Entity\User $user */
        $user = $this->request->getAttribute('identity')->getOriginalData();

        if (!$user->checkCapability('DIRECTORY')) {
            $this->Flash->error('Results limited due to user permissions.');
        }

        $query = $this->Users->find('search', [
            'search' => $this->getRequest()->getQueryParams(),
            'collection' => UsersCollection::class,
        ])
        ->contain([
            'Roles' => [
                'RoleTypes',
                'Sections.SectionTypes',
            ],
            'UserContacts',
        ]);
        $users = $this->paginate($this->Authorization->applyScope($query));
        $this->set(compact('users'));

        $this->whyPermitted($this->Users);
    }

    /**
     * View method
     *
     * @param string|null $userId User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($userId = null)
    {
        $blockedFields = $this->Authorization->see($this->Users->get($userId));

        $result = $this->Authorization->checkCapability('HISTORY');

        if ($result instanceof ResultInterface) {
            $result = $result->getStatus();
        }

        $containArray = [
            'UserStates',
            'Roles' => [
                'RoleTypes',
                'Sections' => [
                    'ScoutGroups',
                    'SectionTypes',
                ],
                'RoleStatuses',
                'UserContacts',
            ],
        ];

        if ($result) {
            $containArray = array_merge($containArray, [
                'ContactEmails.DirectoryUsers',
                'ContactNumbers',
                'Audits.Users',
                'Changes' => function (Query $q) {
                    return $q
                        ->limit(50)
                        ->orderDesc(Audit::FIELD_CHANGE_DATE)
                        ->contain([
                            'ChangedUsers',
                            'ChangedRoles' => [
                                'Users',
                                'RoleTypes',
                            ],
                            'ChangedScoutGroups',
                            'ChangedUserContacts' => [
                                'Users',
                                'UserContactTypes',
                            ],
                        ]);
                },
            ]);
        } else {
            $containArray = array_merge($containArray, [
                'ContactEmails',
                'ContactNumbers',
            ]);
        }

        $user = $this->Users
            ->find()
            ->contain($containArray)
            ->where(['Users.' . User::FIELD_ID => $userId])
//            ->selectAllExcept($this->Users, $blockedFields)
            ->first();

        $this->Authorization->authorize($user, 'VIEW');

        $this->set(compact('user'));

        $this->whyPermitted($this->Users);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));

        $this->whyPermitted($this->Users);
    }

    /**
     * Add method
     *
     * @param string $userDirectoryId The API ID of the User
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     * @throws \Exception
     */
    public function import($userDirectoryId)
    {
        $this->loadComponent('GoogleClient');

        $serviceUser = $this->GoogleClient->getUser($userDirectoryId);

        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));

        $this->whyPermitted($this->Users);
    }

    /**
     * Edit method
     *
     * @param string|null $userId User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($userId = null)
    {
        $user = $this->Users->get($userId, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($user);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'view', $user->get('id')]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));

        $this->whyPermitted($this->Users);
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
        $this->viewBuilder()->setLayout('login');

        /** @var \App\Authenticator\CognitoResult $result */
        $result = $this->Authentication->getResult();

        // Redirect if challenged
        if ($result instanceof CognitoResult && $result->isChallenge()) {
            return $this->redirect([
                'controller' => 'Challenges',
                'action' => 'expired',
                '?' => $this->request->getQuery(),
            ]);
        }

        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $event = new Event('Model.Users.login', $this, [
                'user' => $result->getData(),
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
        $this->Authorization->skipAuthorization();

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
     * @throws \Exception
     */
    public function forgot()
    {
        $this->viewBuilder()->setLayout('login');

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

                    $sendCode = 'USR-' . $user->id . '-PWD';
                    $this->loadModel('EmailSends');

                    if ($this->EmailSends->make($sendCode)) {
                        $message = 'We have sent a password reset token to your email.';
                        $message .= ' This is valid for a short period of time.';
                        $this->Flash->success($message);

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
     * @throws \Exception
     */
    public function username()
    {
        $this->viewBuilder()->setLayout('login');

        $resForm = new ResetForm();
        $this->set(compact('resForm'));

        if ($this->request->is('post')) {
            $found = $this
                ->Users
                ->find('all')
                ->where([
                    'membership_number' => $this->request->getData('membership_number'),
                    'first_name' => $this->request->getData('first_name'),
                    'last_name' => $this->request->getData('last_name'),
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
     * @return \Cake\Http\Response|void
     */
    public function password()
    {
        $changeType = self::CHANGE_TYPE_UNAUTHORIZED;
        $this->loadModel('Tokens');

        $resetToken = $this->Tokens->validateTokenRequest($this->request->getQueryParams());

        if ($resetToken instanceof Token) {
            $resetUser = $resetToken->email_send->user;
            if ($resetUser instanceof User) {
                $changeType = self::CHANGE_TYPE_RESET;
            }
        }

        if ($changeType == self::CHANGE_TYPE_UNAUTHORIZED) {
            $identity = $this->Authentication->getIdentity();
            if ($identity instanceof User) {
                $changeType = self::CHANGE_TYPE_UPDATE;
                $resetUser = $identity;
            }
        }

        if ($changeType == self::CHANGE_TYPE_UNAUTHORIZED) {
            $this->Flash->error('Password Reset Token could not be validated.');

            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $passwordForm = new PasswordForm();

        if (
            $changeType > self::CHANGE_TYPE_UNAUTHORIZED
            && isset($resetUser)
            && $resetUser instanceof User
            && $this->request->is('post')
        ) {
            if (!$passwordForm->validate($this->request->getData())) {
                $this->Flash->error(__('The data provided has errors.'));
            } else {
                if (
                    $passwordForm->execute([
                    'request' => $this->request->getData(),
                    'user' => $resetUser,
                    ])
                ) {
                    $this->Flash->success('Your password was saved successfully.');

                    return $this->redirect(['prefix' => false, 'controller' => 'Users', 'action' => 'login']);
                }

                $this->Flash->error(__('The password security could not  be validated. Is your postcode correct?'));
            }
        }

        $this->set(compact('passwordForm'));
    }

    /**
     * Token - Completes Password Reset Function
     *
     * @return \Cake\Http\Response|void
     */
    public function welcome()
    {
        $this->loadModel('Tokens');
        $this->viewBuilder()->setLayout('login');

        $resetToken = $this->Tokens->validateTokenRequest($this->request->getQueryParams());

        if (!$resetToken instanceof Token) {
            $this->Flash->error('Token is Invalid.');

            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $user = $resetToken->email_send->user;
        if (!$user instanceof User) {
            $this->Flash->error('User is Invalid.');

            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $identity = $this->Authentication->getIdentity();
        if ($identity instanceof User) {
            $user = $identity;
        }

        $passwordForm = new PasswordForm();

        if ($user instanceof User && $this->request->is('post')) {
            $newPassword = $this->request->getData($passwordForm::FIELD_NEW_PASSWORD);
            $confirmPassword = $this->request->getData($passwordForm::FIELD_CONFIRM_PASSWORD);

            $passwordData = [
                $passwordForm::FIELD_NEW_PASSWORD => $newPassword,
                $passwordForm::FIELD_CONFIRM_PASSWORD => $confirmPassword,
            ];

            $user = $this->Users->patchEntity($user, $this->request->getData());

            if (!$passwordForm->validate($passwordData)) {
                $this->Flash->error(__('The data provided has errors.'));
            } elseif ($newPassword != $confirmPassword) {
                $this->Flash->error('Passwords do not match.');
            } else {
                $user = $this->Users->patchEntity(
                    $user,
                    [User::FIELD_PASSWORD => $newPassword],
                    [ 'fields' => [$user::FIELD_PASSWORD], 'validate' => false ]
                );

                if ($this->Users->save($user)) {
                    $this->Flash->success('Your username & password were saved successfully.');

                    return $this->redirect(['prefix' => false, 'controller' => 'Users', 'action' => 'login']);
                }

                $this->Flash->error(__('Something went wrong.'));
            }
        }

        $this->set(compact('passwordForm', 'user'));
    }
}
