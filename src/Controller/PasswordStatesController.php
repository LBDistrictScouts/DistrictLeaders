<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\PasswordState;
use Cake\Datasource\ResultSetInterface;

/**
 * PasswordStates Controller
 *
 * @property \App\Model\Table\PasswordStatesTable $PasswordStates
 *
 * @method \App\Model\Entity\PasswordState[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PasswordStatesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $passwordStates = $this->paginate($this->PasswordStates);

        $this->set(compact('passwordStates'));
    }

    /**
     * View method
     *
     * @param string|null $id Password State id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $passwordState = $this->PasswordStates->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('passwordState', $passwordState);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $passwordState = $this->PasswordStates->newEntity();
        if ($this->request->is('post')) {
            $passwordState = $this->PasswordStates->patchEntity($passwordState, $this->request->getData());
            if ($this->PasswordStates->save($passwordState)) {
                $this->Flash->success(__('The password state has been saved.'));

                return $this->redirect(['action' => 'view', $passwordState->get('id')]);
            }
            $this->Flash->error(__('The password state could not be saved. Please, try again.'));
        }
        $this->set(compact('passwordState'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Password State id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $passwordState = $this->PasswordStates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $passwordState = $this->PasswordStates->patchEntity($passwordState, $this->request->getData());
            if ($this->PasswordStates->save($passwordState)) {
                $this->Flash->success(__('The password state has been saved.'));

                return $this->redirect(['action' => 'view', $passwordState->get('id')]);
            }
            $this->Flash->error(__('The password state could not be saved. Please, try again.'));
        }
        $this->set(compact('passwordState'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Password State id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $passwordState = $this->PasswordStates->get($id);
        if ($this->PasswordStates->delete($passwordState)) {
            $this->Flash->success(__('The password state has been deleted.'));
        } else {
            $this->Flash->error(__('The password state could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
