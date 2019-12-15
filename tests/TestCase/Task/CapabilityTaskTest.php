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
 * @property \App\Model\Table\RoleTypesTable $RoleTypes
 */
class CapabilityTaskTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * Test subject
     *
     * @var \App\Shell\Task\QueueCapabilityTask
     */
    public $QueueCapabilityTask;

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
     * Test initial setup
     *
     * @return void
     */
    public function testCapabilityQueueJob()
    {
        $this->QueuedJobs = TableRegistry::getTableLocator()->get('Queue.QueuedJobs');
        $this->RoleTypes = TableRegistry::getTableLocator()->get('RoleTypes');
        $originalJobCount = $this->QueuedJobs->find('all')->count();

        $roleType = $this->RoleTypes->get(1);

        $this->QueuedJobs->createJob(
            'Capability',
            ['role_template_id' => $roleType->role_template_id]
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
    public function testCapabilityQueueJobEntityMissing()
    {
        $this->QueuedJobs = TableRegistry::getTableLocator()->get('Queue.QueuedJobs');
        $originalJobCount = $this->QueuedJobs->find('all')->count();

        $this->QueuedJobs->createJob(
            'Capability',
            []
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
}
