<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * EmailResponseTypes Controller
 *
 * @property \App\Model\Table\EmailResponseTypesTable $EmailResponseTypes
 * @method \App\Model\Entity\EmailResponseType[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailResponseTypesController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $emailResponseTypes = $this->paginate($this->EmailResponseTypes);

        $this->set(compact('emailResponseTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Email Response Type id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): void
    {
        $emailResponseType = $this->EmailResponseTypes->get($id, [
            'contain' => ['EmailResponses'],
        ]);

        $this->set('emailResponseType', $emailResponseType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): void
    {
        $emailResponseType = $this->EmailResponseTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $emailResponseType = $this->EmailResponseTypes->patchEntity($emailResponseType, $this->request->getData());
            if ($this->EmailResponseTypes->save($emailResponseType)) {
                $this->Flash->success(__('The email response type has been saved.'));

                $this->redirect(['action' => 'view', $emailResponseType->get('id')]);
            }
            $this->Flash->error(__('The email response type could not be saved. Please, try again.'));
        }
        $this->set(compact('emailResponseType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Email Response Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): void
    {
        $emailResponseType = $this->EmailResponseTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailResponseType = $this->EmailResponseTypes->patchEntity($emailResponseType, $this->request->getData());
            if ($this->EmailResponseTypes->save($emailResponseType)) {
                $this->Flash->success(__('The email response type has been saved.'));

                $this->redirect(['action' => 'view', $emailResponseType->get('id')]);
            }
            $this->Flash->error(__('The email response type could not be saved. Please, try again.'));
        }
        $this->set(compact('emailResponseType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Email Response Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $emailResponseType = $this->EmailResponseTypes->get($id);
        if ($this->EmailResponseTypes->delete($emailResponseType)) {
            $this->Flash->success(__('The email response type has been deleted.'));
        } else {
            $this->Flash->error(__('The email response type could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }
}
