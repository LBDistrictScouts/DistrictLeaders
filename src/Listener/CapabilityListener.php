<?php
declare(strict_types=1);

namespace App\Listener;

use Cake\Event\EventListenerInterface;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Class LoginEvent
 *
 * @package App\Listener
 * @property \App\Model\Table\RoleTemplatesTable $RoleTemplates
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class CapabilityListener implements EventListenerInterface
{
    use LocatorAwareTrait;

    /**
     * @return array
     */
    public function implementedEvents(): array
    {
        return [
            'Model.RoleTemplates.templateChange' => 'templateChange',
        ];
    }

    /**
     * @param \Cake\Event\Event $event The event being processed.
     * @return void
     */
    public function templateChange($event)
    {
        /** @var \App\Model\Entity\RoleTemplate $roleTemplate */
        $roleTemplate = $event->getData('role_template');

        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
        $this->QueuedJobs->createJob(
            'Capability',
            ['role_template_id' => $roleTemplate->id]
        );
    }
}
