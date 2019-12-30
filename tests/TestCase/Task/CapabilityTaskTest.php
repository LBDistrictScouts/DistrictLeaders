<?php
declare(strict_types=1);

namespace App\Test\TestCase\Task;

use App\Model\Entity\RoleTemplate;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Mailer\BasicMailer Test Case
 *
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 * @property \App\Model\Table\RoleTemplatesTable $RoleTemplates
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
        $originalJobCount = $this->QueuedJobs->find('all')->count();

        $this->QueuedJobs->createJob(
            'Capability',
            ['role_template_id' => 1]
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        $this->useCommandRunner();
        $this->exec('queue runworker');

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find('all')->orderDesc('created')->first();
        if ($job instanceof \Queue\Model\Entity\QueuedJob) {
            TestCase::assertEquals(0, $job->get('failed'));
        }
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testWholeCapabilityQueueJob()
    {
        $this->QueuedJobs = TableRegistry::getTableLocator()->get('Queue.QueuedJobs');
        $this->RoleTemplates = TableRegistry::getTableLocator()->get('RoleTemplates');
        $originalJobCount = $this->QueuedJobs->find('all')->count();
        $originalRoleType = $this->RoleTemplates->RoleTypes->get(1, ['contain' => 'Capabilities']);

        $roleTemplate = $this->RoleTemplates->get(1);
        $roleTemplate->set(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, ['LOGIN', 'ADD_GROUP', 'EDIT_GROUP']);
        $roleTemplate = $this->RoleTemplates->save($roleTemplate);
        TestCase::assertInstanceOf($this->RoleTemplates->getEntityClass(), $roleTemplate);

        $this->QueuedJobs->createJob(
            'Capability',
            ['role_template_id' => 1]
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        $this->useCommandRunner();
        $this->exec('queue runworker');

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find('all')->orderDesc('created')->first();
        if ($job instanceof \Queue\Model\Entity\QueuedJob) {
            TestCase::assertEquals(0, $job->get('failed'));
        }

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
        if ($job instanceof \Queue\Model\Entity\QueuedJob) {
            TestCase::assertEquals(0, $job->get('failed'));
        }
    }
}
