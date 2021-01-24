<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Role;
use App\Model\Entity\User;
use App\Model\Entity\UserContact;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
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
     * @param string|null $roleId Role id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($roleId = null)
    {
        $role = $this->Roles->get($roleId, [
            'contain' => ['RoleTypes', 'Sections', 'Users', 'RoleStatuses', 'UserContacts',
                'Audits' => [
                    'sort' => [ 'Audits.change_date' => 'DESC' ],
                    'Users',
                    'NewSections',
                    'NewRoleTypes',
                    'NewUsers',
                    'NewUserContacts',
                    'NewRoleStatuses',
                    'OriginalSections',
                    'OriginalRoleTypes',
                    'OriginalUsers',
                    'OriginalUserContacts',
                    'OriginalRoleStatuses',
                ],
            ],
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
        if (key_exists('user_id', $this->request->getQueryParams())) {
            $user_id = $this->request->getQueryParams()['user_id'];
        }

        $role = $this->Roles->newEmptyEntity();

        if (isset($user_id)) {
            $user = $this->Roles->Users->find()
                ->where([User::FIELD_ID => $user_id])->firstOrFail();
            $this->set(compact('user'));

            $role->set(Role::FIELD_USER_ID, $user->get(User::FIELD_ID));
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (
                !key_exists(UserContact::FIELD_USER_ID, $data)
                && !is_null($role->get(UserContact::FIELD_USER_ID))
            ) {
                $data[UserContact::FIELD_USER_ID] = $role->get(UserContact::FIELD_USER_ID);
            }
            $role = $this->Roles->patchEntity($role, $data);
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'edit', $role->get('id'), '?' => ['contact' => true]]);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $roleTypes = $this->Roles->RoleTypes->find('list', ['limit' => 200]);
        $sections = $this->Roles->Sections->find('list', ['limit' => 200]);

        $roleStatuses = $this->Roles->RoleStatuses->find('list', ['limit' => 200]);

        if (!isset($user)) {
            $users = $this->Roles->Users->find('list', ['limit' => 200]);
            $users = $this->Authorization->applyScope($users, 'edit');
            $this->set(compact('users'));
        }

        $this->set(compact('role', 'roleTypes', 'sections', 'roleStatuses'));
    }

    /**
     * Edit method
     *
     * @param string|null $roleId Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($roleId = null)
    {
        $contact = $this->getRequest()->getQueryParams()['contact'] ?? false;
        $this->set('contact', $contact);

        $role = $this->Roles->get($roleId, [
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
            ->find('contactEmails')
            ->where(['user_id' => $role->user_id]);

        $this->set(compact('role', 'roleTypes', 'sections', 'userContacts', 'roleStatuses'));
    }

    /**
     * Delete method
     *
     * @param string|null $roleId Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($roleId = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($roleId);
        if ($this->Roles->delete($role)) {
            $this->Flash->success(__('The role has been deleted.'));
        } else {
            $this->Flash->error(__('The role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
