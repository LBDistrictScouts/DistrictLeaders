<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CampRoles Controller
 *
 * @property \App\Model\Table\CampRolesTable $CampRoles
 * @method \App\Model\Entity\CampRole[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CampRolesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(): ?Response
    {
        $this->paginate = [
            'contain' => ['Camps', 'Users', 'CampRoleTypes'],
        ];
        $campRoles = $this->paginate($this->CampRoles);

        $this->set(compact('campRoles'));
    }

    /**
     * View method
     *
     * @param string|null $id Camp Role id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): ?Response
    {
        $campRole = $this->CampRoles->get($id, [
            'contain' => ['Camps', 'Users', 'CampRoleTypes'],
        ]);

        $this->set('campRole', $campRole);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
    {
        $campRole = $this->CampRoles->newEmptyEntity();
        if ($this->request->is('post')) {
            $campRole = $this->CampRoles->patchEntity($campRole, $this->request->getData());
            if ($this->CampRoles->save($campRole)) {
                $this->Flash->success(__('The camp role has been saved.'));

                return $this->redirect(['action' => 'view', $campRole->get('id')]);
            }
            $this->Flash->error(__('The camp role could not be saved. Please, try again.'));
        }
        $camps = $this->CampRoles->Camps->find('list', ['limit' => 200]);
        $users = $this->CampRoles->Users->find('list', ['limit' => 200]);
        $campRoleTypes = $this->CampRoles->CampRoleTypes->find('list', ['limit' => 200]);
        $this->set(compact('campRole', 'camps', 'users', 'campRoleTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Camp Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): ?Response
    {
        $campRole = $this->CampRoles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $campRole = $this->CampRoles->patchEntity($campRole, $this->request->getData());
            if ($this->CampRoles->save($campRole)) {
                $this->Flash->success(__('The camp role has been saved.'));

                return $this->redirect(['action' => 'view', $campRole->get('id')]);
            }
            $this->Flash->error(__('The camp role could not be saved. Please, try again.'));
        }
        $camps = $this->CampRoles->Camps->find('list', ['limit' => 200]);
        $users = $this->CampRoles->Users->find('list', ['limit' => 200]);
        $campRoleTypes = $this->CampRoles->CampRoleTypes->find('list', ['limit' => 200]);
        $this->set(compact('campRole', 'camps', 'users', 'campRoleTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Camp Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $campRole = $this->CampRoles->get($id);
        if ($this->CampRoles->delete($campRole)) {
            $this->Flash->success(__('The camp role has been deleted.'));
        } else {
            $this->Flash->error(__('The camp role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
