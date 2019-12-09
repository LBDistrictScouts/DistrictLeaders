<?php
namespace App\Listener;

use App\Model\Entity\Role;
use Cake\Event\EventListenerInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

/**
 * Class LoginEvent
 *
 * @package App\Listener
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class CapabilityListener implements EventListenerInterface
{
    /**
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Model.RoleTemplates.templateChange' => 'templateChange',
        ];
    }

    /**
     * @param \Cake\Event\Event $event The event being processed.
     *
     * @return void
     */
    public function templateChange($event)
    {
        /** @var \App\Model\Entity\RoleTemplate $roleTemplate */
        $roleTemplate = $event->getData('role_template');

        $this->QueuedJobs = TableRegistry::getTableLocator()->get('Queue.QueuedJobs');
        $this->QueuedJobs->createJob(
            'Capability',
            ['role_template' => $roleTemplate]
        );
    }
}
