<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\UserContact;
use Cake\Datasource\ResultSetInterface;

/**
 * UserContacts Controller
 *
 * @property \App\Model\Table\UserContactsTable $UserContacts
 *
 * @method \App\Model\Entity\UserContact[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
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
            'contain' => ['Users']
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
            'contain' => ['Users', 'Roles']
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
        if ($this->request->is('post')) {
            $userContact = $this->UserContacts->patchEntity($userContact, $this->request->getData());
            if ($this->UserContacts->save($userContact)) {
                $this->Flash->success(__('The user contact has been saved.'));

                return $this->redirect(['action' => 'view', $userContact->get('id')]);
            }
            $this->Flash->error(__('The user contact could not be saved. Please, try again.'));
        }
        $users = $this->UserContacts->Users->find('list', ['limit' => 200]);
        $this->set(compact('userContact', 'users'));
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
        $this->set(compact('userContact', 'users'));
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
