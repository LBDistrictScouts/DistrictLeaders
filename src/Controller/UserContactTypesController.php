<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\UserContactType;
use App\Model\Table\UserContactTypesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * UserContactTypes Controller
 *
 * @property UserContactTypesTable $UserContactTypes
 * @method UserContactType[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserContactTypesController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $userContactTypes = $this->paginate($this->UserContactTypes);

        $this->set(compact('userContactTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id User Contact Type id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userContactType = $this->UserContactTypes->get($id, [
            'contain' => ['UserContacts'],
        ]);

        $this->set('userContactType', $userContactType);
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userContactType = $this->UserContactTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $userContactType = $this->UserContactTypes->patchEntity($userContactType, $this->request->getData());
            if ($this->UserContactTypes->save($userContactType)) {
                $this->Flash->success(__('The user contact type has been saved.'));

                return $this->redirect(['action' => 'view', $userContactType->get('id')]);
            }
            $this->Flash->error(__('The user contact type could not be saved. Please, try again.'));
        }
        $this->set(compact('userContactType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User Contact Type id.
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userContactType = $this->UserContactTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userContactType = $this->UserContactTypes->patchEntity($userContactType, $this->request->getData());
            if ($this->UserContactTypes->save($userContactType)) {
                $this->Flash->success(__('The user contact type has been saved.'));

                return $this->redirect(['action' => 'view', $userContactType->get('id')]);
            }
            $this->Flash->error(__('The user contact type could not be saved. Please, try again.'));
        }
        $this->set(compact('userContactType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User Contact Type id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userContactType = $this->UserContactTypes->get($id);
        if ($this->UserContactTypes->delete($userContactType)) {
            $this->Flash->success(__('The user contact type has been deleted.'));
        } else {
            $this->Flash->error(__('The user contact type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
