<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\User;
use App\Model\Entity\UserContact;
use App\Model\Entity\UserContactType;
use Cake\Datasource\ResultSetInterface;

/**
 * UserContacts Controller
 *
 * @property \App\Model\Table\UserContactsTable $UserContacts
 *
 * @method UserContact[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserContactsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'UserContactTypes']
        ];
        $userContacts = $this->paginate($this->UserContacts);

        $this->set(compact('userContacts'));
    }

    /**
     * View method
     *
     * @param string|null $id User Contact id.
     *
     * @return \Cake\Http\Response|void
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userContact = $this->UserContacts->get($id, [
            'contain' => ['Users', 'UserContactTypes', 'Audits', 'Roles']
        ]);

        $this->set('userContact', $userContact);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userContact = $this->UserContacts->newEntity();
        if (key_exists('user_contact_type', $this->request->getQueryParams())) {
            $contactType = $this->request->getQueryParams()['user_contact_type'];
        }
        if (key_exists('user_id', $this->request->getQueryParams())) {
            $user_id = $this->request->getQueryParams()['user_id'];
        }

        // Set Contact Type if Known
        if (isset($contactType)) {
            /** @var \App\Model\Entity\UserContactType $userContactType */
            $userContactType = $this->UserContacts->UserContactTypes->find()
                ->where([UserContactType::FIELD_USER_CONTACT_TYPE => ucwords($contactType)])->firstOrFail();
            $term = $userContactType->get(UserContactType::FIELD_USER_CONTACT_TYPE);
            $this->set(compact('term'));

            $userContact->set(UserContact::FIELD_USER_CONTACT_TYPE_ID, $userContactType->get(UserContactType::FIELD_ID));
        }

        // Set User if known
        if (isset($user_id)) {
            $user = $this->UserContacts->Users->find()
                ->where([User::FIELD_ID => $user_id])->firstOrFail();
            $this->set(compact('user'));

            $userContact->set(UserContact::FIELD_USER_ID, $user->get(User::FIELD_ID));
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (!key_exists(UserContact::FIELD_USER_ID, $data) && !is_null($userContact->get(UserContact::FIELD_USER_ID))) {
                $data[UserContact::FIELD_USER_ID] = $userContact->get(UserContact::FIELD_USER_ID);
            }
            if (!key_exists(UserContact::FIELD_USER_CONTACT_TYPE_ID, $data) && !is_null($userContact->get(UserContact::FIELD_USER_CONTACT_TYPE_ID))) {
                $data[UserContact::FIELD_USER_CONTACT_TYPE_ID] = $userContact->get(UserContact::FIELD_USER_CONTACT_TYPE_ID);
            }

            $validator = 'default';
            if (isset($contactType) && $contactType == 'email') {
                $validator = $contactType;
            }

            $userContact = $this->UserContacts->patchEntity($userContact, $data, ['validate' => $validator]);
            if ($this->UserContacts->save($userContact)) {
                $this->Flash->success(__('The user contact has been saved.'));

                return $this->redirect(['action' => 'view', $userContact->get('id')]);
            }
            $this->Flash->error(__('The user contact could not be saved. Please, try again.'));
        }
        $this->set(compact('userContact'));

        if (!isset($userContactType)) {
            $userContactTypes = $this->UserContacts->UserContactTypes->find('list', ['limit' => 200]);
            $term = 'User Contact';
            $this->set(compact('userContactTypes', 'term'));
        }

        if (!isset($user)) {
            $users = $this->UserContacts->Users->find('list', ['limit' => 200]);
            $users = $this->Authorization->applyScope($users, 'update');
            $this->set(compact('users'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id User Contact id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userContact = $this->UserContacts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userContact = $this->UserContacts->patchEntity($userContact, $this->request->getData());
            if ($this->UserContacts->save($userContact)) {
                $this->Flash->success(__('The user contact has been saved.'));

                return $this->redirect(['action' => 'view', $userContact->get('id')]);
            }
            $this->Flash->error(__('The user contact could not be saved. Please, try again.'));
        }
        $users = $this->UserContacts->Users->find('list', ['limit' => 200]);
        $userContactTypes = $this->UserContacts->UserContactTypes->find('list', ['limit' => 200]);
        $this->set(compact('userContact', 'users', 'userContactTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User Contact id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userContact = $this->UserContacts->get($id);
        if ($this->UserContacts->delete($userContact)) {
            $this->Flash->success(__('The user contact has been deleted.'));
        } else {
            $this->Flash->error(__('The user contact could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
