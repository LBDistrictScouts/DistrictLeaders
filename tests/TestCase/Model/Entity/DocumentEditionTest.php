<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\DocumentEdition Test Case
 *
 * @property \App\Model\Table\DocumentEditionsTable $DocumentEditions
 */
class DocumentEditionTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\DocumentEdition
     */
    public $DocumentEdition;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FileTypes',
        'app.DocumentTypes',
        'app.Documents',
        'app.DocumentVersions',
        'app.DocumentEditions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->DocumentEditions = TableRegistry::getTableLocator()->get('DocumentEditions');
        $this->DocumentEdition = $this->DocumentEditions->get(1);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DocumentEdition);

        parent::tearDown();
    }

    /**
     * Test getPath method
     *
     * @return void
     */
    public function testGetPath()
    {
        $expected = 'Lorem ipsum dolor sit amet';
        $actual = $this->DocumentEdition->getPath();
        TestCase::assertSame($expected, $actual);
    }

    /**
     * Test setPath method
     *
     * @return void
     */
    public function testSetPath()
    {
        $expected = 'Lorem ipsum dolor sit amet';
        $actual = $this->DocumentEdition->getPath();
        TestCase::assertSame($expected, $actual);

        $expected = 'Jacob Likes Cheese';
        $this->DocumentEdition->setPath($expected);
        $actual = $this->DocumentEdition->getPath();
        TestCase::assertSame($expected, $actual);
    }
}
