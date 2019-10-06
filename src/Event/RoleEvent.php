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
class RoleEvent implements EventListenerInterface
{
    /**
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Model.Role.afterSave' => 'newRole',
        ];
    }

    /**
     * @param \Cake\Event\Event $event The event being processed.
     *
     * @return void
     */
    public function newRole($event)
    {
        /** @var \App\Model\Entity\User $user */
        $user = $event->getData('user');

        $this->updateCapabilities($user);
    }

    /**
     * @param \App\Model\Entity\User $user The user with a new Role
     *
     * @return void
     */
    public function updateCapabilities($user)
    {
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->Users->patchCapabilities($user);
    }
}
