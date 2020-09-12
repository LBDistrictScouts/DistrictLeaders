<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\Directory;
use App\Model\Entity\DocumentVersion;
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
    protected $_defaultConfig = [];

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
        $job = $this->QueuedJobs->createJob('Directory', ['directory' => $directory->id]);
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
        $job = $this->QueuedJobs->createJob('Compass', ['version' => $documentVersion->id]);
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
     * @return void
     */
    public function setCapabilityParse()
    {
        $job = $this->QueuedJobs->createJob('Capability');
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
    public function setUserStateParse()
    {
        $job = $this->QueuedJobs->createJob('State');
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
    public function setUnsent()
    {
        $job = $this->QueuedJobs->createJob('Unsent');
        if ($job instanceof QueuedJob) {
            $this->Flash->queue(
                'Unsent Emails have been dispatched.',
                ['params' => ['job_id' => $job->id]]
            );
        } else {
            $this->Flash->error(__('The Unsent Email process could not be triggered.'));
        }
    }
}
