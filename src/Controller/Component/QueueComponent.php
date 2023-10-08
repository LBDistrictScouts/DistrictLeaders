<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\Directory;
use App\Model\Entity\DocumentVersion;
use App\Queue\Task\AutoMergeTask;
use App\Queue\Task\CapabilityTask;
use App\Queue\Task\CompassTask;
use App\Queue\Task\DirectoryTask;
use App\Queue\Task\StateTask;
use App\Queue\Task\TokenTask;
use App\Queue\Task\UnsentTask;
use Cake\Controller\Component;
use Cake\Datasource\ModelAwareTrait;
use Queue\Model\Entity\QueuedJob;

/**
 * Queue component
 *
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 * @property \Cake\Controller\Component\FlashComponent $Flash
 */
class QueueComponent extends Component
{
    use ModelAwareTrait;

    /**
     * Default configuration.
     *
     * @var array
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $_defaultConfig = [];

    /**
     * @var array|array<string>
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    public $components = ['Flash'];

    /**
     * @inheritDoc
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->loadModel('Queue.QueuedJobs');
    }

    /**
     * @param \App\Model\Entity\Directory $directory The Document Version for Queuing
     * @return void
     */
    public function setDirectoryImport(Directory $directory): void
    {
        $job = $this->QueuedJobs->createJob(DirectoryTask::taskName(), [
            'directory' => $directory->get($directory::FIELD_ID),
        ]);
        if ($job instanceof QueuedJob) {
            $this->Flash->queue(
                'The directory has been set for sync.',
                ['params' => ['job_id' => $job->id]]
            );
        } else {
            $this->Flash->error(__('The directory sync could not be queued. Please, try again.'));
        }
    }

    /**
     * @param \App\Model\Entity\DocumentVersion $documentVersion The Document Version for Queuing
     * @return void
     */
    public function setCompassVersionImport(DocumentVersion $documentVersion): void
    {
        $job = $this->QueuedJobs->createJob(CompassTask::taskName(), [
            'version' => $documentVersion->get($documentVersion::FIELD_ID),
        ]);
        if ($job instanceof QueuedJob) {
            $this->Flash->queue(
                'The document version has been sent for processing.',
                ['params' => ['job_id' => $job->id]]
            );
        } else {
            $this->Flash->error(__('The document version could not be queued. Please, try again.'));
        }
    }

    /**
     * @param \App\Model\Entity\DocumentVersion $documentVersion The Document Version for Queuing
     * @return void
     */
    public function setCompassAutoMerge(DocumentVersion $documentVersion): void
    {
        $job = $this->QueuedJobs->createJob(AutoMergeTask::taskName(), [
            'version' => $documentVersion->get($documentVersion::FIELD_ID),
        ]);
        if ($job instanceof QueuedJob) {
            $this->Flash->queue(
                'The document version has been sent for auto merging.',
                ['params' => ['job_id' => $job->id]]
            );
        } else {
            $this->Flash->error(__('The document version could not be queued. Please, try again.'));
        }
    }

    /**
     * @return void
     */
    public function setCapabilityParse(): void
    {
        $job = $this->QueuedJobs->createJob(CapabilityTask::taskName());
        if ($job instanceof QueuedJob) {
            $this->Flash->queue(
                'System Capabilities have been set for Processing.',
                ['params' => ['job_id' => $job->id]]
            );
        } else {
            $this->Flash->error(__('The Capabilities Process could not be triggered.'));
        }
    }

    /**
     * @return void
     */
    public function setUserStateParse(): void
    {
        $job = $this->QueuedJobs->createJob(StateTask::taskName());
        if ($job instanceof QueuedJob) {
            $this->Flash->queue(
                'Users have been set for state evaluation.',
                ['params' => ['job_id' => $job->id]]
            );
        } else {
            $this->Flash->error(__('The user state evaluation process could not be triggered.'));
        }
    }

    /**
     * @return void
     */
    public function setUnsent(): void
    {
        $job = $this->QueuedJobs->createJob(UnsentTask::taskName());
        if ($job instanceof QueuedJob) {
            $this->Flash->queue(
                'Unsent Emails have been dispatched.',
                ['params' => ['job_id' => $job->id]]
            );
        } else {
            $this->Flash->error(__('The Unsent Email process could not be triggered.'));
        }
    }

    /**
     * @return void
     */
    public function setTokenParse(): void
    {
        $job = $this->QueuedJobs->createJob(TokenTask::taskName());
        if ($job instanceof QueuedJob) {
            $this->Flash->queue(
                'Token Parse Initiated.',
                ['params' => ['job_id' => $job->id]]
            );
        } else {
            $this->Flash->error(__('Token Parse process could not be initiated.'));
        }
    }
}
