<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\GoogleClientComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\GoogleClientComponent Test Case
 */
class GoogleClientComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\GoogleClientComponent
     */
    public $GoogleClient;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->GoogleClient = new GoogleClientComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GoogleClient);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     * @throws \Google_Exception
     */
    public function testInitialization()
    {
        $this->markTestIncomplete();

        $out = $this->GoogleClient->getList();

        $expected = [
            'jacob',
        ];

        TestCase::assertEquals($expected, $out);
    }
}
