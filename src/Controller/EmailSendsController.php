<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\EmailSend;

/**
 * EmailSends Controller
 *
 * @property \App\Model\Table\EmailSendsTable $EmailSends
 * @property \App\Controller\Component\QueueComponent $Queue
 * @method \App\Model\Entity\EmailSend[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailSendsController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $this->paginate = [
            'contain' => ['Users', 'Notifications'],
            'order' => [
                'created' => 'DESC',
            ],
        ];
        $emailSends = $this->paginate($this->EmailSends);

        $this->set(compact('emailSends'));
    }

    /**
     * View method
     *
     * @param string|null $id Email Send id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): void
    {
        $emailSend = $this->EmailSends->get($id, [
            'contain' => ['Users', 'Notifications', 'EmailResponses', 'Tokens'],
        ]);

        $this->set('emailSend', $emailSend);
    }

    /**
     * Delete method
     *
     * @param string|null $emailId Email Send id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function send(?string $emailId = null): void
    {
        $this->request->allowMethod(['post']);
        if ($this->EmailSends->send((int)$emailId)) {
            $this->Flash->success(__('The email has been sent.'));
        } else {
            $this->Flash->error(__('The email send could not be sent. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }

    /**
     * Add method
     *
     * @param string $notificationId Notification ID
     * @return \Cake\Http\Response Redirects on successful add, renders view otherwise.
     */
    public function make(string $notificationId): Response
    {
        $this->request->allowMethod(['post']);
        $notification = $this->EmailSends->Notifications->get($notificationId, ['contain' => 'NotificationTypes']);
        $user = $this->EmailSends->Users->get($notification->user_id);

        $result = $this->EmailSends->generate($notification, $user, $notification->email_code, []);

        if ($result instanceof EmailSend) {
            $this->Flash->success('Email Send Succeeded.');
            $this->EmailSends->send($result->id);
        } else {
            $this->Flash->error('Email Send Failed.');
        }

        $this->redirect(['controller' => 'Notifications', 'actions' => 'view', $notificationId]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Email Send id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): void
    {
        $emailSend = $this->EmailSends->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailSend = $this->EmailSends->patchEntity($emailSend, $this->request->getData());
            if ($this->EmailSends->save($emailSend)) {
                $this->Flash->success(__('The email send has been saved.'));

                $this->redirect(['action' => 'view', $emailSend->get('id')]);
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
    public function delete(?string $id = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $emailSend = $this->EmailSends->get($id);
        if ($this->EmailSends->delete($emailSend)) {
            $this->Flash->success(__('The email send has been deleted.'));
        } else {
            $this->Flash->error(__('The email send could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }

    /**
     * Process method
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException|\App\Controller\Exception When record not found.
     */
    public function unsent(): void
    {
        $this->request->allowMethod(['post']);

        $this->loadComponent('Queue');
        $this->Queue->setUnsent();

        $this->redirect(['controller' => 'Admin', 'action' => 'index']);
    }
}
