<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * UserContactTypes Controller
 *
 * @property \App\Model\Table\UserContactTypesTable $UserContactTypes
 * @method \App\Model\Entity\UserContactType[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserContactTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(): ?Response
    {
        $userContactTypes = $this->paginate($this->UserContactTypes);

        $this->set(compact('userContactTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id User Contact Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): ?Response
    {
        $userContactType = $this->UserContactTypes->get($id, [
            'contain' => ['UserContacts'],
        ]);

        $this->set('userContactType', $userContactType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
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
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): ?Response
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
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): ?Response
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
