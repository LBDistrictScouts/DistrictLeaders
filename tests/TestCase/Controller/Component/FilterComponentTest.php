<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\FilterComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\FilterComponent Test Case
 */
class FilterComponentTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Test subject
     *
     * @var \App\Controller\Component\FilterComponent
     */
    public $Filter;

    /**
     * Test subject
     *
     * @var \Cake\Controller\Controller
     */
    public $Controller;

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
        $request = new ServerRequest();
        $response = new Response();
        $this->Controller = $this->getMockBuilder('Cake\Controller\Controller')
                                 ->setConstructorArgs([$request, $response])
                                 ->setMethods()
                                 ->getMock();
        $registry = new ComponentRegistry($this->Controller);
        $this->Filter = new FilterComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Filter);

        parent::tearDown();
    }

    /**
     * Test indexFilters method
     *
     * @return void
     */
    public function testNoIndexFilters()
    {
        $baseTable = TableRegistry::getTableLocator()->get('Documents');
        $association = $baseTable->getAssociation('DocumentTypes');
        $returnedQuery = $this->Filter->indexFilters(
            $association,
            []
        );

        $viewVars = $this->Controller->viewVars;
        TestCase::assertArrayHasKey('filterArray', $viewVars);
        TestCase::assertArrayHasKey('appliedFilters', $viewVars);

        TestCase::assertSame([1 => 'Lorem ipsum dolor sit amet'], $viewVars['filterArray']);

        TestCase::assertArrayHasKey('DocumentTypes', $returnedQuery->getContain());

        $baseTable = TableRegistry::getTableLocator()->get('Roles');
        $association = $baseTable->getAssociation('RoleTypes');
        $returnedQuery = $this->Filter->indexFilters(
            $association,
            []
        );

        $viewVars = $this->Controller->viewVars;
        TestCase::assertArrayHasKey('filterArray', $viewVars);
        TestCase::assertArrayHasKey('appliedFilters', $viewVars);

        $expected = [
            1 => 'Lorem ipsum dolor sit amet',
            2 => 'Lorem ipsum dolor sit amet',
            3 => 'Lorem ipsum dolor sit amet',
            4 => 'Lorem ipsum dolor sit amet',
            5 => 'Lorem ipsum dolor sit amet',
            6 => 'Lorem ipsum dolor sit amet',
            7 => 'Lorem  dolor sit amet',
        ];
        TestCase::assertSame($expected, $viewVars['filterArray']);

        TestCase::assertArrayHasKey('RoleTypes', $returnedQuery->getContain());
    }

    /**
     * Test indexFilters method
     *
     * @return void
     */
    public function testActiveIndexFilters()
    {
        // Setup Base Table & Association
        $baseTable = TableRegistry::getTableLocator()->get('Documents');
        $association = $baseTable->getAssociation('DocumentTypes');

        // Pass Component
        $returnedQuery = $this->Filter->indexFilters(
            $association,
            [
                'Lorem ipsum dolor sit amet' => true,
            ]
        );

        // Check Result Contains Association
        TestCase::assertArrayHasKey('DocumentTypes', $returnedQuery->getContain());

        // Collect View Vars
        $viewVars = $this->Controller->viewVars;

        // Check Filter Array Variable
        TestCase::assertArrayHasKey('filterArray', $viewVars);
        $expected = [
            1 => 'Lorem ipsum dolor sit amet',
        ];
        TestCase::assertSame($expected, $viewVars['filterArray']);

        // Check Applied Filters Variable
        TestCase::assertArrayHasKey('appliedFilters', $viewVars);
        $expected = [
            0 => 'Lorem ipsum dolor sit amet',
        ];
        TestCase::assertSame($expected, $viewVars['appliedFilters']);

        // Check Filter Applied
        TestCase::assertStringContainsString($association->getForeignKey() . ' in (:c0)', $returnedQuery->sql());
        $expected = [
            ':c0' => [
                'value' => 1,
                'type' => 'integer',
                'placeholder' => 'c0',
            ],
        ];
        TestCase::assertSame($expected, $returnedQuery->getValueBinder()->bindings());

        $baseTable = TableRegistry::getTableLocator()->get('Roles');
        $association = $baseTable->getAssociation('RoleTypes');
        $returnedQuery = $this->Filter->indexFilters(
            $association,
            [
                'Lorem  dolor sit amet' => true,
            ]
        );

        $viewVars = $this->Controller->viewVars;
        TestCase::assertArrayHasKey('filterArray', $viewVars);
        $expected = [
            1 => 'Lorem ipsum dolor sit amet',
            2 => 'Lorem ipsum dolor sit amet',
            3 => 'Lorem ipsum dolor sit amet',
            4 => 'Lorem ipsum dolor sit amet',
            5 => 'Lorem ipsum dolor sit amet',
            6 => 'Lorem ipsum dolor sit amet',
            7 => 'Lorem  dolor sit amet',
        ];
        TestCase::assertSame($expected, $viewVars['filterArray']);

        TestCase::assertArrayHasKey('appliedFilters', $viewVars);
        $expected = [
            0 => 'Lorem  dolor sit amet',
        ];
        TestCase::assertSame($expected, $viewVars['appliedFilters']);

        TestCase::assertArrayHasKey('RoleTypes', $returnedQuery->getContain());

        TestCase::assertStringContainsString($association->getForeignKey() . ' in (:c0)', $returnedQuery->sql());
        $expected = [
            ':c0' => [
                'value' => 7,
                'type' => 'integer',
                'placeholder' => 'c0',
            ],
        ];
        TestCase::assertSame($expected, $returnedQuery->getValueBinder()->bindings());
    }
}