<?php
namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

/**
 * Class LoginEvent
 *
 * @package App\Event
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UserEvent implements EventListenerInterface
{
    /**
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Model.User.login' => 'updateLogin',
        ];
    }

    /**
     * @param \Cake\Event\Event $event The event being processed.
     *
     * @return void
     */
    public function updateLogin($event)
    {
        /** @var \App\Model\Entity\User $subject */
        $user = $event->getData('user');
        $this->Users = TableRegistry::getTableLocator()->get('Users');

        $user->set('last_login', FrozenTime::now());
        $user->setDirty('modified', true);

        $this->Users->save($user);
    }
}
