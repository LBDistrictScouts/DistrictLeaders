<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\CloudConvertClientComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\CloudConvertClientComponent Test Case
 */
class CloudConvertClientComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\CloudConvertClientComponent
     */
    public $CloudConvertClient;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->CloudConvertClient = new CloudConvertClientComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CloudConvertClient);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
