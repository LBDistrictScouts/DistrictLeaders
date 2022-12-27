<?php

declare(strict_types=1);

namespace App\Listener;

use App\Model\Entity\RoleTemplate;
use App\Model\Table\RoleTemplatesTable;
use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;
use Cake\ORM\Locator\LocatorAwareTrait;
use Queue\Model\Table\QueuedJobsTable;

/**
 * Class LoginEvent
 *
 * @package App\Listener
 * @property RoleTemplatesTable $RoleTemplates
 * @property QueuedJobsTable $QueuedJobs
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
     * @param EventInterface $event The event being processed.
     * @return void
     */
    public function templateChange(EventInterface $event)
    {
        /** @var RoleTemplate $roleTemplate */
        $roleTemplate = $event->getData('role_template');

        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
        $this->QueuedJobs->createJob(
            'Capability',
            ['role_template_id' => $roleTemplate->id]
        );
    }
}
