<?php
declare(strict_types=1);

namespace App\Shell\Task;

use Queue\Shell\Task\QueueTask;
use Queue\Shell\Task\QueueTaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property \App\Model\Table\EmailSendsTable EmailSends
 */
class QueueUnsentTask extends QueueTask implements QueueTaskInterface
{
    use JobDataTrait;

    /**
     * @var int
     */
    public $timeout = 20;

    /**
     * @var int
     */
    public $retries = 2;

    protected $outputKey = 'output';

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, $jobId): void
    {
        $this->loadModel('EmailSends');

        /** @var \App\Model\Entity\EmailSend[] $unsent */
        $unsent = $this->EmailSends->find('unsent');
        $found = 0;
        $sent = 0;

        foreach ($unsent as $email) {
            $success = $this->EmailSends->send($email->get($email::FIELD_ID));

            $found += 1;
            if ($success) {
                $sent += 1;
            }
        }

        $this->saveJobResult((int)$jobId, __('{0} emails sent of {1} found.', $sent, $found), $this->outputKey);
    }
}
