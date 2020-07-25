<?php
declare(strict_types=1);

namespace App\Test\TestCase\Task;

use App\Model\Entity\RoleTemplate;
use App\Shell\Task\QueueCapabilityTask;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOutput;
use Cake\TestSuite\TestCase;

/**
 * App\Mailer\BasicMailer Test Case
 *
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 * @property \App\Model\Table\RoleTemplatesTable $RoleTemplates
 */
class CapabilityTaskTest extends TestCase
{
    /**
     * @var QueueCapabilityTask|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $Task;

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

        $this->out = new ConsoleOutput();
        $this->err = new ConsoleOutput();
        $testIo = new ConsoleIo($this->out, $this->err);

        $this->Task = new QueueCapabilityTask($testIo);
    }

    /**
     * Test initial setup
     *
     * @return void
     * @throws \Throwable
     */
    public function testCapabilityQueueJob()
    {
        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
        $originalJobCount = $this->QueuedJobs->find('all')->count();
        TestCase::assertEquals(0, $originalJobCount);

        $this->QueuedJobs->createJob(
            'Capability',
            ['role_template_id' => 1]
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find()->first();
        $data = unserialize($job->get('data'));

        $this->Task->run($data, $job->id);

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find('all')->orderDesc('created')->first();

        TestCase::assertEquals(1, $job->progress);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testWholeCapabilityQueueJob()
    {
        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
        $this->RoleTemplates = $this->getTableLocator()->get('RoleTemplates');
        $originalJobCount = $this->QueuedJobs->find('all')->count();
        $originalRoleType = $this->RoleTemplates->RoleTypes->get(1, ['contain' => 'Capabilities']);

        $roleTemplate = $this->RoleTemplates->get(1);
        $roleTemplate->set(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, ['LOGIN', 'CREATE_SCOUT_GROUP', 'UPDATE_SCOUT_GROUP']);
        $roleTemplate = $this->RoleTemplates->save($roleTemplate);
        TestCase::assertInstanceOf($this->RoleTemplates->getEntityClass(), $roleTemplate);

        $this->QueuedJobs->createJob(
            'Capability',
            ['role_template_id' => 1]
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        $job = $this->QueuedJobs->find()->first();
        $data = unserialize($job->get('data'));

        $this->Task->run($data, $job->id);

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find('all')->orderDesc('created')->first();
        TestCase::assertEquals(1, $job->progress);

        $updatedRoleType = $this->RoleTemplates->RoleTypes->get(1, ['contain' => 'Capabilities']);
        TestCase::assertNotSame($originalRoleType, $updatedRoleType);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testCapabilityQueueJobEntityMissing()
    {
        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
        $originalJobCount = $this->QueuedJobs->find('all')->count();

        $this->QueuedJobs->createJob(
            'Capability',
            []
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        $job = $this->QueuedJobs->find()->first();
        $data = unserialize($job->get('data'));

        $this->Task->run($data, $job->id);

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find('all')->orderDesc('created')->first();
        TestCase::assertEquals(1, $job->progress);
    }
}
