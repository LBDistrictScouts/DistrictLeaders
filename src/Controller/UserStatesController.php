<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\UserState;

/**
 * UserStates Controller
 *
 * @property \App\Model\Table\UserStatesTable $UserStates
 * @property \App\Controller\Component\QueueComponent $Queue
 * @method \App\Model\Entity\UserState[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */

class UserStatesController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $userStates = $this->paginate($this->UserStates);

        $this->set(compact('userStates'));
    }

    /**
     * View method
     *
     * @param string|null $userStateId User State id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $userStateId = null): void
    {
        $userState = $this->UserStates->get($userStateId, [
            'contain' => ['Users'],
        ]);

        $this->set('userState', $userState);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add(): void
    {
        $userState = $this->UserStates->newEmptyEntity();
        if ($this->request->is('post')) {
            $userState = $this->UserStates->patchEntity($userState, $this->request->getData());
            if ($this->UserStates->save($userState)) {
                $this->Flash->success(__('The user state has been saved.'));

                $this->redirect(['action' => 'view', $userState->get(UserState::FIELD_ID)]);
            }
            $this->Flash->error(__('The user state could not be saved. Please, try again.'));
        }
        $this->set(compact('userState'));
    }

    /**
     * Edit method
     *
     * @param string|null $userStateId User State id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $userStateId = null): void
    {
        $userState = $this->UserStates->get($userStateId, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userState = $this->UserStates->patchEntity($userState, $this->request->getData());
            if ($this->UserStates->save($userState)) {
                $this->Flash->success(__('The user state has been saved.'));

                $this->redirect(['action' => 'view', $userState->get(UserState::FIELD_ID)]);
            }
            $this->Flash->error(__('The user state could not be saved. Please, try again.'));
        }
        $this->set(compact('userState'));
    }

    /**
     * Delete method
     *
     * @param string|null $userStateId User State id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $userStateId = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $userState = $this->UserStates->get($userStateId);
        if ($this->UserStates->delete($userState)) {
            $this->Flash->success(__('The user state has been deleted.'));
        } else {
            $this->Flash->error(__('The user state could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }

    /**
     * Process method
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException|\App\Controller\Exception When record not found.
     */
    public function process(): void
    {
        $this->request->allowMethod(['post']);

        $this->loadComponent('Queue');
        $this->Queue->setUserStateParse();

        $this->redirect(['controller' => 'Admin', 'action' => 'index']);
    }
}
