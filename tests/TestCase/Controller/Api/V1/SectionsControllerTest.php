<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\V1;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Api\V1\SectionsController Test Case
 *
 * @uses \App\Controller\Api\V1\SectionsController
 */
class SectionsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->get([
            'prefix' => 'Api/V1',
            'controller' => 'Sections',
            '_ext' => 'json',
        ]);

        $this->assertResponseOk();

        $this->assertContentType('json');
    }
}
