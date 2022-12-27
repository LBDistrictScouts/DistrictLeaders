<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Component\QueueComponent;
use App\Model\Entity\EmailSend;
use App\Model\Table\EmailSendsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Exception;

/**
 * EmailSends Controller
 *
 * @property EmailSendsTable $EmailSends
 * @property QueueComponent $Queue
 * @method EmailSend[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailSendsController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
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
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
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
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function send($emailId = null)
    {
        $this->request->allowMethod(['post']);
        if ($this->EmailSends->send((int)$emailId)) {
            $this->Flash->success(__('The email has been sent.'));
        } else {
            $this->Flash->error(__('The email send could not be sent. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Add method
     *
     * @param string $notificationId Notification ID
     * @return Response Redirects on successful add, renders view otherwise.
     */
    public function make(string $notificationId)
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

        return $this->redirect(['controller' => 'Notifications', 'actions' => 'view', $notificationId]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Email Send id.
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
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
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
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

    /**
     * Process method
     *
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException|Exception When record not found.
     */
    public function unsent()
    {
        $this->request->allowMethod(['post']);

        $this->loadComponent('Queue');
        $this->Queue->setUnsent();

        return $this->redirect(['controller' => 'Admin', 'action' => 'index']);
    }
}
