<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\NotificationType;
use App\Model\Table\NotificationTypesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * NotificationTypes Controller
 *
 * @property NotificationTypesTable $NotificationTypes
 * @method NotificationType[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationTypesController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $notificationTypes = $this->paginate($this->NotificationTypes);

        $this->set(compact('notificationTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Notification Type id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notificationType = $this->NotificationTypes->get($id, [
            'contain' => ['Notifications'],
        ]);

        $this->set('notificationType', $notificationType);
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notificationType = $this->NotificationTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $notificationType = $this->NotificationTypes->patchEntity($notificationType, $this->request->getData());
            if ($this->NotificationTypes->save($notificationType)) {
                $this->Flash->success(__('The notification type has been saved.'));

                return $this->redirect(['action' => 'view', $notificationType->get('id')]);
            }
            $this->Flash->error(__('The notification type could not be saved. Please, try again.'));
        }
        $this->set(compact('notificationType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notification Type id.
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notificationType = $this->NotificationTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notificationType = $this->NotificationTypes->patchEntity($notificationType, $this->request->getData());
            if ($this->NotificationTypes->save($notificationType)) {
                $this->Flash->success(__('The notification type has been saved.'));

                return $this->redirect(['action' => 'view', $notificationType->get('id')]);
            }
            $this->Flash->error(__('The notification type could not be saved. Please, try again.'));
        }
        $this->set(compact('notificationType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notification Type id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notificationType = $this->NotificationTypes->get($id);
        if ($this->NotificationTypes->delete($notificationType)) {
            $this->Flash->success(__('The notification type has been deleted.'));
        } else {
            $this->Flash->error(__('The notification type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
