<?php
namespace App\Test\TestCase\Task;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Mailer\BasicMailer Test Case
 *
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class EmailTaskTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * Test subject
     *
     * @var \App\Shell\Task\QueueEmailTask
     */
    public $QueueEmailTask;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PasswordStates',
        'app.Users',
        'app.CapabilitiesRoleTypes',
        'app.Capabilities',
        'app.ScoutGroups',
        'app.SectionTypes',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.Audits',
        'app.UserContactTypes',
        'app.UserContacts',
        'app.Roles',
        'app.CampTypes',
        'app.Camps',
        'app.CampRoleTypes',
        'app.CampRoles',
        'app.Notifications',
        'app.NotificationTypes',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',
        'plugin.Queue.QueuedJobs',
        'plugin.Queue.QueueProcesses'
    ];

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testEmailQueueJob()
    {
        $this->QueuedJobs = TableRegistry::getTableLocator()->get('Queue.QueuedJobs');
        $originalJobCount = $this->QueuedJobs->find('all')->count();

        $this->QueuedJobs->createJob(
            'Email',
            ['email_generation_code' => 'USR-2-NEW']
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        $this->useCommandRunner();
        $this->exec('queue runworker');

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find('all')->orderDesc('created')->first();
        TestCase::assertEquals(0, $job->failed);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testEmailQueueJobCodeException()
    {
        $this->QueuedJobs = TableRegistry::getTableLocator()->get('Queue.QueuedJobs');
        $originalJobCount = $this->QueuedJobs->find('all')->count();

        $this->QueuedJobs->createJob(
            'Email',
            []
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        $this->useCommandRunner();
        $this->exec('queue runworker');

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find('all')->orderDesc('created')->first();
        TestCase::assertEquals(1, $job->failed);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testEmailQueueJobSendException()
    {
        $this->QueuedJobs = TableRegistry::getTableLocator()->get('Queue.QueuedJobs');
        $originalJobCount = $this->QueuedJobs->find('all')->count();

        $this->QueuedJobs->createJob(
            'Email',
            ['email_generation_code' => 'BRO-9-EXE']
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        $this->useCommandRunner();
        $this->exec('queue runworker');

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find('all')->orderDesc('created')->first();
        TestCase::assertEquals(1, $job->failed);
    }
}
