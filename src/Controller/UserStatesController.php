<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Component\QueueComponent;
use App\Model\Entity\UserState;
use App\Model\Table\UserStatesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Exception;

/**
 * UserStates Controller
 *
 * @property UserStatesTable $UserStates
 * @property QueueComponent $Queue
 * @method UserState[]|ResultSetInterface paginate($object = null, array $settings = [])
 */

class UserStatesController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $userStates = $this->paginate($this->UserStates);

        $this->set(compact('userStates'));
    }

    /**
     * View method
     *
     * @param string|null $userStateId User State id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($userStateId = null)
    {
        $userState = $this->UserStates->get($userStateId, [
            'contain' => ['Users'],
        ]);

        $this->set('userState', $userState);
    }

    /**
     * Add method
     *
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userState = $this->UserStates->newEmptyEntity();
        if ($this->request->is('post')) {
            $userState = $this->UserStates->patchEntity($userState, $this->request->getData());
            if ($this->UserStates->save($userState)) {
                $this->Flash->success(__('The user state has been saved.'));

                return $this->redirect(['action' => 'view', $userState->get(UserState::FIELD_ID)]);
            }
            $this->Flash->error(__('The user state could not be saved. Please, try again.'));
        }
        $this->set(compact('userState'));
    }

    /**
     * Edit method
     *
     * @param string|null $userStateId User State id.
     * @return Response|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($userStateId = null)
    {
        $userState = $this->UserStates->get($userStateId, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userState = $this->UserStates->patchEntity($userState, $this->request->getData());
            if ($this->UserStates->save($userState)) {
                $this->Flash->success(__('The user state has been saved.'));

                return $this->redirect(['action' => 'view', $userState->get(UserState::FIELD_ID)]);
            }
            $this->Flash->error(__('The user state could not be saved. Please, try again.'));
        }
        $this->set(compact('userState'));
    }

    /**
     * Delete method
     *
     * @param string|null $userStateId User State id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($userStateId = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userState = $this->UserStates->get($userStateId);
        if ($this->UserStates->delete($userState)) {
            $this->Flash->success(__('The user state has been deleted.'));
        } else {
            $this->Flash->error(__('The user state could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Process method
     *
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException|Exception When record not found.
     */
    public function process()
    {
        $this->request->allowMethod(['post']);

        $this->loadComponent('Queue');
        $this->Queue->setUserStateParse();

        return $this->redirect(['controller' => 'Admin', 'action' => 'index']);
    }
}
