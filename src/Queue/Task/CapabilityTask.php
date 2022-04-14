<?php
declare(strict_types=1);

namespace App\Queue\Task;

use App\Model\Entity\RoleType;
use Queue\Queue\Task;
use Queue\Queue\TaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property \App\Model\Table\RoleTypesTable $RoleTypes
 */
class CapabilityTask extends Task implements TaskInterface
{
    use JobDataTrait;

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
    public function run(array $data, $jobId): void
    {
        $this->loadModel('RoleTypes');

        $passed = 0;
        $idx = 0;

        $query = $this->RoleTypes->find('all')->contain(['Capabilities', 'RoleTemplates']);

        if (key_exists('role_template_id', $data) && is_numeric($data['role_template_id'])) {
            $query = $query->where([RoleType::FIELD_ROLE_TEMPLATE_ID => $data['role_template_id']]);
        }

        $records = $query->count();
        foreach ($query as $roleType) {
            $idx += 1;
            $roleType = $this->RoleTypes->patchTemplateCapabilities($roleType);
            if ($this->RoleTypes->save($roleType) instanceof RoleType) {
                $passed += 1;
                $this->RoleTypes->patchRoleUsers($roleType);
            }
            $this->QueuedJobs->updateProgress($jobId, $idx / $records);
        }

        $this->saveJobDataArray((int)$jobId, compact('passed', 'records'));
    }
}
