<?php
declare(strict_types=1);

namespace App\Test\TestCase\Task;

use App\Shell\Task\QueueEmailTask;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOutput;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Mailer\BasicMailer Test Case
 */
class EmailTaskTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Shell\Task\QueueEmailTask
     */
    protected $Task;

    /**
     * @var \Cake\ORM\Table|\Queue\Model\Table\QueuedJobsTable
     */
    protected $QueuedJobs;

    /**
     * @var \Tools\TestSuite\ConsoleOutput
     */
    protected $out;

    /**
     * @var \Tools\TestSuite\ConsoleOutput
     */
    protected $err;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserStates',
        'app.Users',
        'app.CapabilitiesRoleTypes',
        'app.Capabilities',
        'app.ScoutGroups',
        'app.SectionTypes',
        'app.RoleTemplates',
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
        'plugin.Queue.QueueProcesses',
    ];

    /**
     * Setup Defaults
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->QueuedJobs = TableRegistry::getTableLocator()->get('Queue.QueuedJobs');

        $this->out = new ConsoleOutput();
        $this->err = new ConsoleOutput();
        $testIo = new ConsoleIo($this->out, $this->err);

        $this->Task = new QueueEmailTask($testIo);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testEmailQueueJob()
    {
        $originalJobCount = $this->QueuedJobs->find('all')->count();
        TestCase::assertEquals(0, $originalJobCount);

        $this->QueuedJobs->createJob(
            'Email',
            ['email_generation_code' => 'USR-2-NEW']
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find()->first();
        $data = unserialize($job->get('data'));

        $this->Task->run($data, $job->id);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testEmailQueueJobCodeException()
    {
        $originalJobCount = $this->QueuedJobs->find('all')->count();
        TestCase::assertEquals(0, $originalJobCount);

        $this->QueuedJobs->createJob(
            'Email',
            []
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find()->first();
        $data = unserialize($job->get('data'));

        $this->expectExceptionMessage('Email generation code not specified.');
        $this->expectException('Queue\Model\QueueException');
        $this->Task->run($data, $job->id);
    }
}
