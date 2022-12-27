<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Component\CapAuthorizationComponent;
use App\Form\PasswordForm;
use App\Model\Entity\Token;
use App\Model\Entity\User;
use App\Model\Table\TokensTable;
use App\Model\Table\UsersTable;
use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Controller\Controller;
use Cake\Http\Response;
use Cake\ORM\Table;
use Exception;
use Flash\Controller\Component\FlashComponent;

/**
 * Challenges Controller
 *
 * @property AuthenticationComponent $Authentication
 * @property CapAuthorizationComponent $Authorization
 *
 * @property FlashComponent $Flash
 *
 * @property TokensTable $Tokens
 * @property UsersTable $Users
 * @property Table $Challenges
 **/
class ChallengesController extends Controller
{
    protected const CHANGE_TYPE_UNAUTHORIZED = 0;
    protected const CHANGE_TYPE_RESET = 1;
    protected const CHANGE_TYPE_UPDATE = 2;
    protected const CHANGE_TYPE_EXPIRED = 3;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     * @throws Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');

        $this->Authentication->allowUnauthenticated(['expired']);
        $this->Authentication->addUnauthenticatedActions(['expired']);

        $this->loadComponent('Flash.Flash');

        $this->loadComponent('Authorization.Authorization', ['className' => 'CapAuthorization']);
        $this->Authorization->skipAuthorization();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function expired()
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

//        debug(CognitoResult::CHALLENGE_EXPIRED_PASSWORD);

        $authSession = $this->request->getSession()->read('Auth');
        if (isset($authSession['challenge']) && $authSession['challenge'] == 'NEW_PASSWORD_REQUIRED') {
            $changeType = self::CHANGE_TYPE_EXPIRED;

            $this->loadModel('Users');
            $username = $authSession['challengeParameters']['USER_ID_FOR_SRP'];
            $resetUser = $this->Users->find()->where(['username ILIKE' => $username])->firstOrFail();
        }

//        debug($authSession);
//        debug($changeType);

//        if ($changeType == self::CHANGE_TYPE_UNAUTHORIZED) {
////            $this->Flash->error('Password Reset Token could not be validated.');
//
////            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
//        }

        $passwordForm = new PasswordForm();

        if ($changeType > self::CHANGE_TYPE_UNAUTHORIZED && $this->request->is('post')) {
//            debug('Post');
            if (!$passwordForm->validate($this->request->getData())) {
                $this->Flash->error(__('The data provided has errors.'));
            } else {
                $result = $passwordForm->execute([
                    'request' => $this->request->getData(),
                    'user' => $resetUser,
                    'auth' => $authSession,
                ]);
//                debug($result);

                if ($result) {
                    $this->Flash->success('Your password was saved successfully.');

                    return $this->redirect(['prefix' => false, 'controller' => 'Users', 'action' => 'login']);
                }

                $this->Flash->error(__('The password security could not be validated. Is your postcode correct?'));
            }
        }

        $this->set(compact('passwordForm'));
    }
}
