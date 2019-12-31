<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Capability;
use App\Model\Table\CapabilitiesTable;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
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
            Capability::FIELD_CAPABILITY_CODE => 'NEW' . random_int(0, 999),
            Capability::FIELD_CAPABILITY => 'Llama Permissions' . random_int(0, 999),
            Capability::FIELD_MIN_LEVEL => random_int(0, 5),
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
            Capability::FIELD_ID => 1,
            Capability::FIELD_CAPABILITY_CODE => 'ALL',
            Capability::FIELD_CAPABILITY => 'SuperUser Permissions',
            Capability::FIELD_MIN_LEVEL => 5,
            Capability::FIELD_CRUD_FUNCTION => 'SPECIAL',
            Capability::FIELD_APPLICABLE_MODEL => 'SPECIAL',
            Capability::FIELD_APPLICABLE_FIELD => false,
            Capability::FIELD_IS_FIELD_CAPABILITY => false,
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
            Capability::FIELD_MIN_LEVEL,
            Capability::FIELD_CAPABILITY_CODE,
            Capability::FIELD_CAPABILITY,
        ];
        $this->validateRequired($required, $this->Capabilities, [$this, 'getGood']);

        $notEmpties = [
            Capability::FIELD_MIN_LEVEL,
            Capability::FIELD_CAPABILITY_CODE,
            Capability::FIELD_CAPABILITY,
        ];
        $this->validateNotEmpties($notEmpties, $this->Capabilities, [$this, 'getGood']);

        $maxLengths = [
            Capability::FIELD_CAPABILITY_CODE => 63,
            Capability::FIELD_CAPABILITY => 255,
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
            Capability::FIELD_CAPABILITY_CODE,
            Capability::FIELD_CAPABILITY,
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
                        Capability::FIELD_ID => 7,
                        Capability::FIELD_CAPABILITY_CODE => 'CREATE_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'Create Scout Group',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 8,
                        Capability::FIELD_CAPABILITY_CODE => 'UPDATE_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'Update Scout Group',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 9,
                        Capability::FIELD_CAPABILITY_CODE => 'VIEW_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'View Scout Group',
                        Capability::FIELD_MIN_LEVEL => 1,
                    ],
                    [
                        Capability::FIELD_ID => 10,
                        Capability::FIELD_CAPABILITY_CODE => 'DELETE_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'Delete Scout Group',
                        Capability::FIELD_MIN_LEVEL => 5,
                    ],
                ],
            ],
            'Protected Scout Group Entity' => [
                'ScoutGroups',
                3,
                true,
                [
                    [
                        Capability::FIELD_ID => 7,
                        Capability::FIELD_CAPABILITY_CODE => 'CREATE_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'Create Scout Group',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 8,
                        Capability::FIELD_CAPABILITY_CODE => 'UPDATE_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'Update Scout Group',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 9,
                        Capability::FIELD_CAPABILITY_CODE => 'VIEW_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'View Scout Group',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                    [
                        Capability::FIELD_ID => 10,
                        Capability::FIELD_CAPABILITY_CODE => 'DELETE_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'Delete Scout Group',
                        Capability::FIELD_MIN_LEVEL => 5,
                    ],
                ],
            ],
            'Protected Section Entity' => [
                'Sections',
                2,
                true,
                [
                    [
                        Capability::FIELD_ID => 7,
                        Capability::FIELD_CAPABILITY_CODE => 'CREATE_SECTION',
                        Capability::FIELD_CAPABILITY => 'Create Section',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                    [
                        Capability::FIELD_ID => 8,
                        Capability::FIELD_CAPABILITY_CODE => 'UPDATE_SECTION',
                        Capability::FIELD_CAPABILITY => 'Update Section',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                    [
                        Capability::FIELD_ID => 9,
                        Capability::FIELD_CAPABILITY_CODE => 'VIEW_SECTION',
                        Capability::FIELD_CAPABILITY => 'View Section',
                        Capability::FIELD_MIN_LEVEL => 2,
                    ],
                    [
                        Capability::FIELD_ID => 10,
                        Capability::FIELD_CAPABILITY_CODE => 'DELETE_SECTION',
                        Capability::FIELD_CAPABILITY => 'Delete Section',
                        Capability::FIELD_MIN_LEVEL => 5,
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

    /**
     * @return array
     */
    public function providerFieldCapability()
    {
        return [
            'Capabilities Entity' => [
                'Capabilities',
                3,
                8,
                [
                    [
                        Capability::FIELD_ID => 7,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_CAPABILITIES@ID',
                        Capability::FIELD_CAPABILITY => 'Change field "Id" on Capabilities',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 8,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_CAPABILITIES@CAPABILITY_CODE',
                        Capability::FIELD_CAPABILITY => 'Change field "Capability Code" on Capabilities',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 9,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_CAPABILITIES@CAPABILITY',
                        Capability::FIELD_CAPABILITY => 'Change field "Capability" on Capabilities',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 10,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_CAPABILITIES@MIN_LEVEL',
                        Capability::FIELD_CAPABILITY => 'Change field "Min Level" on Capabilities',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 11,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_VIEW_CAPABILITIES@ID',
                        Capability::FIELD_CAPABILITY => 'View field "Id" on Capabilities',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                    [
                        Capability::FIELD_ID => 12,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_VIEW_CAPABILITIES@CAPABILITY_CODE',
                        Capability::FIELD_CAPABILITY => 'View field "Capability Code" on Capabilities',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                    [
                        Capability::FIELD_ID => 13,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_VIEW_CAPABILITIES@CAPABILITY',
                        Capability::FIELD_CAPABILITY => 'View field "Capability" on Capabilities',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                    [
                        Capability::FIELD_ID => 14,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_VIEW_CAPABILITIES@MIN_LEVEL',
                        Capability::FIELD_CAPABILITY => 'View field "Min Level" on Capabilities',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                ],
                [
                    Capability::FIELD_ID => 7,
                    Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_CAPABILITIES@ID',
                    Capability::FIELD_CAPABILITY => 'Change field "Id" on Capabilities',
                    Capability::FIELD_MIN_LEVEL => 4,
                    Capability::FIELD_CRUD_FUNCTION => 'CHANGE',
                    Capability::FIELD_APPLICABLE_MODEL => 'CAPABILITIES',
                    Capability::FIELD_APPLICABLE_FIELD => 'ID',
                    Capability::FIELD_IS_FIELD_CAPABILITY => true,
                ],
            ],
        ];
    }

    /**
     * Test entityCapability method
     *
     * @dataProvider providerFieldCapability
     *
     * @param string $entity The entity being created
     * @param int $baseLevel The Base Level of the Entity Test
     * @param int $fieldCount The number of fields
     * @param array $expected Entities Created
     * @param array $hydrated First Entity
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testFieldCapability($entity, $baseLevel, $fieldCount, $expected, $hydrated)
    {
        $result = $this->Capabilities->fieldCapability($entity, $baseLevel);
        TestCase::assertEquals($fieldCount, $result);

        $entitySearchValue = '%' . strtoupper(Inflector::singularize(Inflector::underscore($entity)));
        $fieldSearchValue = 'FIELD_%';
        $searchField = Capability::FIELD_CAPABILITY_CODE . ' LIKE';
        $query = $this->Capabilities->find()->where([
            $searchField => $entitySearchValue,
            $searchField => $fieldSearchValue,
        ]);
        TestCase::assertEquals($fieldCount, $query->count());

        TestCase::assertEquals($hydrated, $query->first()->toArray());

        $query = $this->Capabilities->find()->where([
            $searchField => $entitySearchValue,
            $searchField => $fieldSearchValue,
        ]);

        TestCase::assertEquals($expected, $query->disableHydration()->toArray());

        $result = $this->Capabilities->fieldCapability('Cheeses', 99);
        TestCase::assertFalse($result);
    }

    /**
     * @return array
     */
    public function providerBuildCapability()
    {
        return [
            'Create Capabilities' => [
                'CREATE',
                'Capabilities',
                'CREATE_CAPABILITY',
            ],
            'Bad Action' => [
                'JSKLSLS',
                'Capabilities',
                false,
            ],
            'Bad Model' => [
                'CREATE',
                'KASKDD',
                false,
            ],
        ];
    }

    /**
     * Test Build Capability Method and safety overloads
     *
     * @dataProvider providerBuildCapability
     *
     * @param string $action Action being entered
     * @param string $model Model being entered
     * @param string|false $expected Expectation of result
     */
    public function testBuildCapability($action, $model, $expected)
    {
        $result = $this->Capabilities->buildCapability($action, $model);
        TestCase::assertEquals($expected, $result);
    }
}
