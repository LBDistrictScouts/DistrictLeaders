<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * NotificationTypes Controller
 *
 * @property \App\Model\Table\NotificationTypesTable $NotificationTypes
 * @method \App\Model\Entity\NotificationType[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationTypesController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $notificationTypes = $this->paginate($this->NotificationTypes);

        $this->set(compact('notificationTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Notification Type id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): void
    {
        $notificationType = $this->NotificationTypes->get($id, [
            'contain' => ['Notifications'],
        ]);

        $this->set('notificationType', $notificationType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): void
    {
        $notificationType = $this->NotificationTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $notificationType = $this->NotificationTypes->patchEntity($notificationType, $this->request->getData());
            if ($this->NotificationTypes->save($notificationType)) {
                $this->Flash->success(__('The notification type has been saved.'));

                $this->redirect(['action' => 'view', $notificationType->get('id')]);
            }
            $this->Flash->error(__('The notification type could not be saved. Please, try again.'));
        }
        $this->set(compact('notificationType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notification Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): void
    {
        $notificationType = $this->NotificationTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notificationType = $this->NotificationTypes->patchEntity($notificationType, $this->request->getData());
            if ($this->NotificationTypes->save($notificationType)) {
                $this->Flash->success(__('The notification type has been saved.'));

                $this->redirect(['action' => 'view', $notificationType->get('id')]);
            }
            $this->Flash->error(__('The notification type could not be saved. Please, try again.'));
        }
        $this->set(compact('notificationType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notification Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $notificationType = $this->NotificationTypes->get($id);
        if ($this->NotificationTypes->delete($notificationType)) {
            $this->Flash->success(__('The notification type has been deleted.'));
        } else {
            $this->Flash->error(__('The notification type could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }
}
