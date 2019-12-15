<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\EmailSend;
use Cake\Datasource\ResultSetInterface;

/**
 * EmailSends Controller
 *
 * @property \App\Model\Table\EmailSendsTable $EmailSends
 *
 * @method EmailSend[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailSendsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Notifications'],
        ];
        $emailSends = $this->paginate($this->EmailSends);

        $this->set(compact('emailSends'));
    }

    /**
     * View method
     *
     * @param string|null $id Email Send id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emailSend = $this->EmailSends->get($id, [
            'contain' => ['Users', 'Notifications', 'EmailResponses', 'Tokens'],
        ]);

        $this->set('emailSend', $emailSend);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $emailSend = $this->EmailSends->newEntity();
        if ($this->request->is('post')) {
            $emailSend = $this->EmailSends->patchEntity($emailSend, $this->request->getData());
            if ($this->EmailSends->save($emailSend)) {
                $this->Flash->success(__('The email send has been saved.'));

                return $this->redirect(['action' => 'view', $emailSend->get('id')]);
            }
            $this->Flash->error(__('The email send could not be saved. Please, try again.'));
        }
        $users = $this->EmailSends->Users->find('list', ['limit' => 200]);
        $notifications = $this->EmailSends->Notifications->find('list', ['limit' => 200]);
        $this->set(compact('emailSend', 'users', 'notifications'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Email Send id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $emailSend = $this->EmailSends->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailSend = $this->EmailSends->patchEntity($emailSend, $this->request->getData());
            if ($this->EmailSends->save($emailSend)) {
                $this->Flash->success(__('The email send has been saved.'));

                return $this->redirect(['action' => 'view', $emailSend->get('id')]);
            }
            $this->Flash->error(__('The email send could not be saved. Please, try again.'));
        }
        $users = $this->EmailSends->Users->find('list', ['limit' => 200]);
        $notifications = $this->EmailSends->Notifications->find('list', ['limit' => 200]);
        $this->set(compact('emailSend', 'users', 'notifications'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Email Send id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $emailSend = $this->EmailSends->get($id);
        if ($this->EmailSends->delete($emailSend)) {
            $this->Flash->success(__('The email send has been deleted.'));
        } else {
            $this->Flash->error(__('The email send could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
