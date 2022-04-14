<?php
declare(strict_types=1);

namespace App\Test\TestCase\Task;

use App\Model\Entity\RoleTemplate;
use App\Model\Table\RoleTemplatesTable;
use App\Queue\Task\CapabilityTask;
use App\Queue\Task\TokenTask;
use App\Test\TestCase\QueueTestCase as TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Queue\Model\Entity\QueuedJob;
use Queue\Model\Table\QueuedJobsTable;
use Throwable;

/**
 * App\Mailer\BasicMailer Test Case
 *
 * @property QueuedJobsTable $QueuedJobs
 * @property RoleTemplatesTable $RoleTemplates
 */
class CapabilityTaskTest extends TestCase
{
    use TaskTestTrait;

    /**
     * @var TokenTask|MockObject
     */
    protected $Task;

    /**
     * Setup Defaults
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->Task = new CapabilityTask();
    }

    /**
     * Test initial setup
     *
     * @return void
     * @throws Throwable
     */
    public function testCapabilityQueueJob()
    {
        $job = $this->checkCreateJob('Capability', ['role_template_id' => 1]);
        $data = unserialize($job->get('data'));

        $this->Task->run($data, $job->id);
        $job = $this->QueuedJobs->get($job->id);

        TestCase::assertEquals(1, $job->progress);
        $this->validateExpectedData([
            'role_template_id' => 1,
            'passed' => 7,
            'records' => 7,
        ], $job->id);
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

        /** @var QueuedJob $job */
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

        /** @var QueuedJob $job */
        $job = $this->QueuedJobs->find('all')->orderDesc('created')->first();
        TestCase::assertEquals(1, $job->progress);
    }
}
