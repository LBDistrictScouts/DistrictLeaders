<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\QueueComponent;
use App\Model\Entity\Directory;
use App\Model\Entity\DocumentVersion;
use App\Test\TestCase\ComponentTestCase as TestCase;
use Cake\Controller\Component\FlashComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * App\Controller\Component\QueueComponent Test Case
 *
 * @property QueueComponent $Queue
 * @property ComponentRegistry $Registry
 *
 * @property \App\Model\Table\DirectoriesTable $Directories
 */
class QueueComponentTest extends TestCase
{
    use LocatorAwareTrait;

    /**
     * Test subject
     *
     * @var \App\Controller\Component\QueueComponent
     */
    protected $Queue;

    /**
     * setUp method
     *
     * @return void
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $request = new ServerRequest();
        $response = new Response();
        $this->Controller = $this->getMockBuilder('Cake\Controller\Controller')
            ->setConstructorArgs([$request, $response])
            ->disableOriginalConstructor()
            ->getMock();

        $this->Registry = new ComponentRegistry();
        $this->Registry->setController($this->Controller);

        $this->Queue = new QueueComponent($this->Registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Queue);
        unset($this->QueuedJobs);

        parent::tearDown();
    }

    /**
     * @param string $jobType The job's expected Type
     * @param array|null $data The data expected to be passed
     */
    public function jobCheck(string $jobType, ?array $data = null)
    {
        $jobs = $this->QueuedJobs->find();
        TestCase::assertEquals(1, $jobs->count());

        $job = $jobs->first();
        TestCase::assertEquals($jobType, $job->get('job_type'));

        if (empty($data)) {
            TestCase::assertNull($job->get('data'));
        } else {
            TestCase::assertEquals($data, unserialize($job->get('data')));
        }
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testSetDirectoryImport(): void
    {
        $directory = $this
            ->getMockBuilder(Directory::class)
            ->getMock();

        $directory
            ->expects(TestCase::once())
            ->method('get')
            ->with('id')
            ->willReturn(1);

        $flash = $this->getMockBuilder(FlashComponent::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$this->Registry])
            ->getMock();

        $flash->expects(TestCase::once())
            ->method('__call')
            ->with(
                'queue',
                [
                    'The directory has been set for sync.',
                    ['params' => ['job_id' => 1]],
                ]
            );

        $this->Queue->Flash = $flash;

        $this->Queue->setDirectoryImport($directory);

        $this->jobCheck('Directory', ['directory' => 1]);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testSetCompassVersionImport(): void
    {
        $documentVersion = $this
            ->getMockBuilder(DocumentVersion::class)
            ->getMock();

        $documentVersion
            ->expects(TestCase::once())
            ->method('get')
            ->with('id')
            ->willReturn(1);

        $flash = $this->getMockBuilder(FlashComponent::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$this->Registry])
            ->getMock();

        $flash->expects(TestCase::once())
            ->method('__call')
            ->with(
                'queue',
                [
                    'The document version has been sent for processing.',
                    ['params' => ['job_id' => 1]],
                ]
            );

        $this->Queue->Flash = $flash;

        $this->Queue->setCompassVersionImport($documentVersion);

        $this->jobCheck('Compass', ['version' => 1]);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testSetCompassAutoMerge(): void
    {
        $documentVersion = $this
            ->getMockBuilder(DocumentVersion::class)
            ->getMock();

        $documentVersion
            ->expects(TestCase::once())
            ->method('get')
            ->with('id')
            ->willReturn(1);

        $flash = $this->getMockBuilder(FlashComponent::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$this->Registry])
            ->getMock();

        $flash->expects(TestCase::once())
            ->method('__call')
            ->with(
                'queue',
                [
                    'The document version has been sent for auto merging.',
                    ['params' => ['job_id' => 1]],
                ]
            );

        $this->Queue->Flash = $flash;

        $this->Queue->setCompassAutoMerge($documentVersion);

        $this->jobCheck('AutoMerge', ['version' => 1]);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testSetCapabilityParse(): void
    {
        $flash = $this->getMockBuilder(FlashComponent::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$this->Registry])
            ->getMock();

        $flash->expects(TestCase::once())
            ->method('__call')
            ->with(
                'queue',
                [
                    'System Capabilities have been set for Processing.',
                    ['params' => ['job_id' => 1]],
                ]
            );

        $this->Queue->Flash = $flash;

        $this->Queue->setCapabilityParse();

        $this->jobCheck('Capability');
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testSetUserStateParse(): void
    {
        $flash = $this->getMockBuilder(FlashComponent::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$this->Registry])
            ->getMock();

        $flash->expects(TestCase::once())
            ->method('__call')
            ->with(
                'queue',
                [
                    'Users have been set for state evaluation.',
                    ['params' => ['job_id' => 1]],
                ]
            );

        $this->Queue->Flash = $flash;

        $this->Queue->setUserStateParse();

        $this->jobCheck('State');
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testSetUnsentParse(): void
    {
        $flash = $this->getMockBuilder(FlashComponent::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$this->Registry])
            ->getMock();

        $flash->expects(TestCase::once())
            ->method('__call')
            ->with(
                'queue',
                [
                    'Unsent Emails have been dispatched.',
                    ['params' => ['job_id' => 1]],
                ]
            );

        $this->Queue->Flash = $flash;

        $this->Queue->setUnsent();

        $this->jobCheck('Unsent');
    }
}
