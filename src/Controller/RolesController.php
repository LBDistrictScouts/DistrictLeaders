<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 *
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['RoleTypes', 'Sections', 'Users', 'RoleStatuses'],
        ];
        $roles = $this->paginate($this->Roles);

        $this->set(compact('roles'));
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['RoleTypes', 'Sections', 'Users', 'RoleStatuses', 'UserContacts'],
        ]);

        $this->set('role', $role);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $role = $this->Roles->newEmptyEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'edit', $role->get('id'), '?' => ['contact' => true]]);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $roleTypes = $this->Roles->RoleTypes->find('list', ['limit' => 200]);
        $sections = $this->Roles->Sections->find('list', ['limit' => 200]);
        $users = $this->Roles->Users->find('list', ['limit' => 200]);
        $roleStatuses = $this->Roles->RoleStatuses->find('list', ['limit' => 200]);

        $this->set(compact('role', 'roleTypes', 'sections', 'users', 'roleStatuses'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contact = $this->getRequest()->getQueryParams()['contact'] ?? false;
        $this->set('contact', $contact);

        $role = $this->Roles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'view', $role->get('id')]);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $roleTypes = $this->Roles->RoleTypes->find('list', ['limit' => 200]);
        $sections = $this->Roles->Sections->find('list', ['limit' => 200]);
        $roleStatuses = $this->Roles->RoleStatuses
            ->find('list', ['limit' => 200]);
        $userContacts = $this->Roles->UserContacts
            ->find('list', ['limit' => 200])
            ->where(['user_id' => $role->user_id]);

        $this->set(compact('role', 'roleTypes', 'sections', 'userContacts', 'roleStatuses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($id);
        if ($this->Roles->delete($role)) {
            $this->Flash->success(__('The role has been deleted.'));
        } else {
            $this->Flash->error(__('The role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
