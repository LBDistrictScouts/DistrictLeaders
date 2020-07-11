<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\API\V1;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\API\V1\SectionsController Test Case
 *
 * @uses \App\Controller\API\V1\SectionsController
 */
class SectionsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Sections',
        'app.SectionTypes',
        'app.ScoutGroups',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->get([
            'prefix' => 'Api/v1',
            'controller' => 'Sections',
            'action' => 'index',
            '_ext' => 'json',
        ]);

        $this->assertResponseOk();

        $this->assertContentType('json');
    }
}
