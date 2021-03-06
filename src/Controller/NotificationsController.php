<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\View\CellTrait;

/**
 * Notifications Controller
 *
 * @property \App\Model\Table\NotificationsTable $Notifications
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationsController extends AppController
{
    use CellTrait;

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->Authorization->authorize($this->Notifications);

        $query = $this->Notifications->find()
            ->contain(['Users', 'NotificationTypes', 'EmailSends.Tokens']);
        $notifications = $this->paginate($this->Authorization->applyScope($query));

        $this->set(compact('notifications'));
        $this->whyPermitted($this->Notifications);
    }

    /**
     * View method
     *
     * @param string|null $notificationId Notification id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($notificationId = null)
    {
        $notification = $this->Notifications->get($notificationId, [
            'contain' => ['Users', 'NotificationTypes', 'EmailSends.Tokens'],
        ]);
        $this->Authorization->authorize($notification, 'VIEW');

        if ($notification->user_id == $this->Authentication->getIdentity()->getIdentifier()) {
            $this->Notifications->markRead($notification);
        }

        $cell = $this->cell('Information', [$notification]);

        $this->set(compact('notification', 'cell'));
        $this->whyPermitted($this->Notifications);
    }

    /**
     * Welcome User method
     *
     * @param string|null $userId Notification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function welcome(?string $userId = null)
    {
        $this->request->allowMethod(['post']);
        $user = $this->Notifications->Users->get($userId);
        if ($this->Notifications->welcome($user)) {
            $this->Flash->success(__('The user has been sent a welcome email.'));
        } else {
            $this->Flash->error(__('The user could not be sent a welcome email. Please, try again.'));
        }

        return $this->redirect(['prefix' => false, 'controller' => 'Users', 'action' => 'view', $userId]);
    }

    /**
     * Delete method
     *
     * @param string|null $notificationId Notification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($notificationId = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notification = $this->Notifications->get($notificationId);
        if ($this->Notifications->delete($notification)) {
            $this->Flash->success(__('The notification has been deleted.'));
        } else {
            $this->Flash->error(__('The notification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
