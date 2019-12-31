<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Capability;
use App\Model\Table\CapabilitiesTable;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Inflector;

/**
 * App\Model\Table\CapabilitiesTable Test Case
 */
class CapabilitiesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\CapabilitiesTable
     */
    public $Capabilities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Capabilities',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Capabilities') ? [] : ['className' => CapabilitiesTable::class];
        $this->Capabilities = TableRegistry::getTableLocator()->get('Capabilities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Capabilities);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     *
     * @throws
     */
    public function getGood()
    {
        return [
            'capability_code' => 'NEW' . random_int(0, 999),
            'capability' => 'Llama Permissions' . random_int(0, 999),
            'min_level' => random_int(0, 5),
        ];
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $expected = [
            'id' => 1,
            'capability_code' => 'ALL',
            'capability' => 'SuperUser Permissions',
            'min_level' => 5,
        ];

        $this->validateInitialise($expected, $this->Capabilities, 6);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->Capabilities->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\Capability', $this->Capabilities->save($new));

        $required = [
            'min_level',
            'capability_code',
            'capability',
        ];
        $this->validateRequired($required, $this->Capabilities, [$this, 'getGood']);

        $notEmpties = [
            'min_level',
            'capability_code',
            'capability',
        ];
        $this->validateNotEmpties($notEmpties, $this->Capabilities, [$this, 'getGood']);

        $maxLengths = [
            'capability_code' => 63,
            'capability' => 255,
        ];
        $this->validateMaxLengths($maxLengths, $this->Capabilities, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Is Unique
        $uniques = [
            'capability_code',
            'capability',
        ];
        $this->validateUniqueRules($uniques, $this->Capabilities, [$this, 'getGood']);
    }

    /**
     * Test installBaseCapabilities method
     *
     * @return void
     */
    public function testInstallBaseCapabilities()
    {
        $this->validateInstallBase($this->Capabilities);
    }

    /**
     * Test generateEntityCapabilities method
     *
     * @return void
     */
    public function testGenerateEntityCapabilities()
    {
        $result = $this->Capabilities->generateEntityCapabilities();

        $models = Configure::read('allModels');
        $methods = Configure::read('entityCapabilities');
        $expected = count($models) * count($methods);

        TestCase::assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function providerEntityCapability()
    {
        return [
            'Unprotected Scout Group Entity' => [
                'ScoutGroups',
                3,
                false,
                [
                    [
                        'id' => 7,
                        'capability_code' => 'CREATE_SCOUT_GROUP',
                        'capability' => 'Create Scout Group',
                        'min_level' => 4,
                    ],
                    [
                        'id' => 8,
                        'capability_code' => 'UPDATE_SCOUT_GROUP',
                        'capability' => 'Update Scout Group',
                        'min_level' => 4,
                    ],
                    [
                        'id' => 9,
                        'capability_code' => 'VIEW_SCOUT_GROUP',
                        'capability' => 'View Scout Group',
                        'min_level' => 1,
                    ],
                    [
                        'id' => 10,
                        'capability_code' => 'DELETE_SCOUT_GROUP',
                        'capability' => 'Delete Scout Group',
                        'min_level' => 5,
                    ],
                ],
            ],
            'Protected Scout Group Entity' => [
                'ScoutGroups',
                3,
                true,
                [
                    [
                        'id' => 7,
                        'capability_code' => 'CREATE_SCOUT_GROUP',
                        'capability' => 'Create Scout Group',
                        'min_level' => 4,
                    ],
                    [
                        'id' => 8,
                        'capability_code' => 'UPDATE_SCOUT_GROUP',
                        'capability' => 'Update Scout Group',
                        'min_level' => 4,
                    ],
                    [
                        'id' => 9,
                        'capability_code' => 'VIEW_SCOUT_GROUP',
                        'capability' => 'View Scout Group',
                        'min_level' => 3,
                    ],
                    [
                        'id' => 10,
                        'capability_code' => 'DELETE_SCOUT_GROUP',
                        'capability' => 'Delete Scout Group',
                        'min_level' => 5,
                    ],
                ],
            ],
            'Protected Section Entity' => [
                'Sections',
                2,
                true,
                [
                    [
                        'id' => 7,
                        'capability_code' => 'CREATE_SECTION',
                        'capability' => 'Create Section',
                        'min_level' => 3,
                    ],
                    [
                        'id' => 8,
                        'capability_code' => 'UPDATE_SECTION',
                        'capability' => 'Update Section',
                        'min_level' => 3,
                    ],
                    [
                        'id' => 9,
                        'capability_code' => 'VIEW_SECTION',
                        'capability' => 'View Section',
                        'min_level' => 2,
                    ],
                    [
                        'id' => 10,
                        'capability_code' => 'DELETE_SECTION',
                        'capability' => 'Delete Section',
                        'min_level' => 5,
                    ],
                ],
            ],
        ];
    }

    /**
     * Test entityCapability method
     *
     * @dataProvider providerEntityCapability
     *
     * @param string $entity The entity being created
     * @param int $baseLevel The Base Level of the Entity Test
     * @param bool $protected Protection Option
     * @param array $expected Entities Created
     *
     * @return void
     */
    public function testEntityCapability($entity, $baseLevel, $protected, $expected)
    {
        $result = $this->Capabilities->entityCapability($entity, $baseLevel, $protected);
        TestCase::assertEquals(4, $result);

        $searchValue = '%' . strtoupper(Inflector::singularize(Inflector::underscore($entity)));
        $searchField = Capability::FIELD_CAPABILITY_CODE . ' LIKE';
        $query = $this->Capabilities->find()->where([$searchField => $searchValue]);
        TestCase::assertEquals(4, $query->count());

        TestCase::assertSame($expected, $query->disableHydration()->toArray());
    }
}
