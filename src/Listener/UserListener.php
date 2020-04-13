<?php
declare(strict_types=1);

namespace App\Listener;

use Cake\Event\EventListenerInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

/**
 * Class LoginEvent
 *
 * @package App\Listener
 * @property \App\Model\Table\UsersTable $Users
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class UserListener implements EventListenerInterface
{
    /**
     * @return array
     */
    public function implementedEvents(): array
    {
        return [
            'Model.Users.login' => 'updateLogin',
            'Model.Users.capabilityChange' => 'capChange',
        ];
    }

    /**
     * @param \Cake\Event\Event $event The event being processed.
     * @return void
     */
    public function updateLogin($event)
    {
        /** @var \App\Model\Entity\User $user */
        $user = $event->getData('user');
        $this->Users = TableRegistry::getTableLocator()->get('Users');

        $user->set('last_login', FrozenTime::now());
        $user->setDirty('modified', true);

        $this->Users->save($user);

        $this->Users->patchCapabilities($user);
    }

    /**
     * @param \Cake\Event\Event $event The event being processed.
     * @return void
     */
    public function capChange($event)
    {
        /** @var \App\Model\Entity\User $user */
        $user = $event->getData('user');

        // Dispatch ASync Notification Task
        $this->QueuedJobs = TableRegistry::getTableLocator()->get('Queue.QueuedJobs');
        $this->QueuedJobs->createJob(
            'Email',
            ['email_generation_code' => 'USR-' . $user->id . '-CCH']
        );
    }
}
