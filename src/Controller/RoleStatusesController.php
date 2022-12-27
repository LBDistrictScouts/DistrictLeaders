<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\RoleStatus;
use App\Model\Table\RoleStatusesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * RoleStatuses Controller
 *
 * @property RoleStatusesTable $RoleStatuses
 * @method RoleStatus[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoleStatusesController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
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
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
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
     * @return Response|null Redirects on successful add, renders view otherwise.
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
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
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
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
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
