<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * RoleStatuses Controller
 *
 * @property \App\Model\Table\RoleStatusesTable $RoleStatuses
 *
 * @method \App\Model\Entity\RoleStatus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoleStatusesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $roleStatuses = $this->paginate($this->RoleStatuses);

        $this->set(compact('roleStatuses'));
    }

    /**
     * View method
     *
     * @param string|null $id Role Status id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $roleStatus = $this->RoleStatuses->get($id, [
            'contain' => ['Roles'],
        ]);

        $this->set('roleStatus', $roleStatus);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $roleStatus = $this->RoleStatuses->newEmptyEntity();
        if ($this->request->is('post')) {
            $roleStatus = $this->RoleStatuses->patchEntity($roleStatus, $this->request->getData());
            if ($this->RoleStatuses->save($roleStatus)) {
                $this->Flash->success(__('The role status has been saved.'));

                return $this->redirect(['action' => 'view', $roleStatus->get('id')]);
            }
            $this->Flash->error(__('The role status could not be saved. Please, try again.'));
        }
        $this->set(compact('roleStatus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Role Status id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roleStatus = $this->RoleStatuses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $roleStatus = $this->RoleStatuses->patchEntity($roleStatus, $this->request->getData());
            if ($this->RoleStatuses->save($roleStatus)) {
                $this->Flash->success(__('The role status has been saved.'));

                return $this->redirect(['action' => 'view', $roleStatus->get('id')]);
            }
            $this->Flash->error(__('The role status could not be saved. Please, try again.'));
        }
        $this->set(compact('roleStatus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role Status id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $roleStatus = $this->RoleStatuses->get($id);
        if ($this->RoleStatuses->delete($roleStatus)) {
            $this->Flash->success(__('The role status has been deleted.'));
        } else {
            $this->Flash->error(__('The role status could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
