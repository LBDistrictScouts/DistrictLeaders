<?php
declare(strict_types=1);

namespace App\Shell\Task;

use App\Model\Entity\RoleTemplate;
use App\Model\Entity\RoleType;
use Queue\Shell\Task\QueueTask;
use Queue\Shell\Task\QueueTaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 *
 * @property \App\Model\Table\RoleTypesTable $RoleTypes
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class QueueCapabilityTask extends QueueTask implements QueueTaskInterface
{
    /**
     * @var int
     */
    public $timeout = 20;

    /**
     * @var int
     */
    public $retries = 1;

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, $jobId)
    {
        $this->loadModel('RoleTypes');
        $this->loadModel('Queue.QueuedJobs');

        $passed = 0;
        $idx = 0;

        $query = $this->RoleTypes->find('all')->contain(['Capabilities', 'RoleTemplates']);

        if (key_exists('role_template_id', $data) && is_numeric($data['role_template_id'])) {
            $query = $query->where([RoleType::FIELD_ROLE_TEMPLATE_ID => $data['role_template_id']]);
        }

        $totalRecords = $query->count();
        foreach ($query as $roleType) {
            $idx += 1;
            $roleType = $this->RoleTypes->patchTemplateCapabilities($roleType);
            if ($this->RoleTypes->save($roleType) instanceof RoleType) {
                $passed += 1;
            }
            $this->QueuedJobs->updateProgress($jobId, $idx / $totalRecords);
        }
    }
}
