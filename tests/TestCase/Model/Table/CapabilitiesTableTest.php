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
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
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
    public function tearDown(): void
    {
        unset($this->Capabilities);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
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
     * @return array
     */
    public function providerFindLevel()
    {
        return [
            'Level 0' => [ 0, 1 ],
            'Level 1' => [ 1, 8 ],
            'Level 2' => [ 2, 30 ],
            'Level 3' => [ 3, 52 ],
            'Level 4' => [ 4, 55 ],
            'Level 5' => [ 5, 65 ],
            'No Level' => [ null, 0 ],
            'Bad Level' => [ 'fish', 0 ],
        ];
    }

    /**
     * Test the level finder function
     *
     * @dataProvider providerFindLevel
     * @param int|null|string $level Min Level
     * @param int $expectedCount Capabilities Found
     */
    public function testFindLevel($level, $expectedCount)
    {
        $this->Capabilities->installBaseCapabilities();

        $query = $this->Capabilities->find('level', ['level' => $level]);
        TestCase::assertEquals($expectedCount, $query->count());

        if (is_numeric($level) && $level == 0) {
            $expected = [
                Capability::FIELD_ID => 6,
                Capability::FIELD_CAPABILITY_CODE => 'LOGIN',
                Capability::FIELD_CAPABILITY => 'Login',
                Capability::FIELD_MIN_LEVEL => 0,
                Capability::FIELD_CRUD_FUNCTION => 'SPECIAL',
                Capability::FIELD_APPLICABLE_MODEL => 'SPECIAL',
                Capability::FIELD_APPLICABLE_FIELD => false,
                Capability::FIELD_IS_FIELD_CAPABILITY => false,
            ];
            TestCase::assertEquals($expected, $query->first()->toArray());
        }
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
        $result = $this->Capabilities->generateEntityCapabilities(false);

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
                        Capability::FIELD_CAPABILITY => 'Create a Scout Group',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 8,
                        Capability::FIELD_CAPABILITY_CODE => 'UPDATE_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'Update a Scout Group',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 9,
                        Capability::FIELD_CAPABILITY_CODE => 'VIEW_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'View a Scout Group',
                        Capability::FIELD_MIN_LEVEL => 1,
                    ],
                    [
                        Capability::FIELD_ID => 10,
                        Capability::FIELD_CAPABILITY_CODE => 'DELETE_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'Delete a Scout Group',
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
                        Capability::FIELD_CAPABILITY => 'Create a Scout Group',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 8,
                        Capability::FIELD_CAPABILITY_CODE => 'UPDATE_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'Update a Scout Group',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 9,
                        Capability::FIELD_CAPABILITY_CODE => 'VIEW_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'View a Scout Group',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                    [
                        Capability::FIELD_ID => 10,
                        Capability::FIELD_CAPABILITY_CODE => 'DELETE_SCOUT_GROUP',
                        Capability::FIELD_CAPABILITY => 'Delete a Scout Group',
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
                        Capability::FIELD_CAPABILITY => 'Create a Section',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                    [
                        Capability::FIELD_ID => 8,
                        Capability::FIELD_CAPABILITY_CODE => 'UPDATE_SECTION',
                        Capability::FIELD_CAPABILITY => 'Update a Section',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                    [
                        Capability::FIELD_ID => 9,
                        Capability::FIELD_CAPABILITY_CODE => 'VIEW_SECTION',
                        Capability::FIELD_CAPABILITY => 'View a Section',
                        Capability::FIELD_MIN_LEVEL => 2,
                    ],
                    [
                        Capability::FIELD_ID => 10,
                        Capability::FIELD_CAPABILITY_CODE => 'DELETE_SECTION',
                        Capability::FIELD_CAPABILITY => 'Delete a Section',
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
     * @param string $entity The entity being created
     * @param int $baseLevel The Base Level of the Entity Test
     * @param bool $protected Protection Option
     * @param array $expected Entities Created
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

        TestCase::assertEquals($expected, $query->disableHydration()->toArray());
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
                16,
                [
                    [
                        Capability::FIELD_ID => 7,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_CAPABILITY@CRUD_FUNCTION',
                        Capability::FIELD_CAPABILITY => 'Change field "Crud Function" on a Capability',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 8,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_CAPABILITY@APPLICABLE_MODEL',
                        Capability::FIELD_CAPABILITY => 'Change field "Applicable Model" on a Capability',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 9,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_CAPABILITY@APPLICABLE_FIELD',
                        Capability::FIELD_CAPABILITY => 'Change field "Applicable Field" on a Capability',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 10,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_CAPABILITY@IS_FIELD_CAPABILITY',
                        Capability::FIELD_CAPABILITY => 'Change field "Is Field Capability" on a Capability',
                        Capability::FIELD_MIN_LEVEL => 4,
                    ],
                    [
                        Capability::FIELD_ID => 11,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_VIEW_CAPABILITY@CRUD_FUNCTION',
                        Capability::FIELD_CAPABILITY => 'View field "Crud Function" on a Capability',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                    [
                        Capability::FIELD_ID => 12,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_VIEW_CAPABILITY@APPLICABLE_MODEL',
                        Capability::FIELD_CAPABILITY => 'View field "Applicable Model" on a Capability',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                    [
                        Capability::FIELD_ID => 13,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_VIEW_CAPABILITY@APPLICABLE_FIELD',
                        Capability::FIELD_CAPABILITY => 'View field "Applicable Field" on a Capability',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                    [
                        Capability::FIELD_ID => 14,
                        Capability::FIELD_CAPABILITY_CODE => 'FIELD_VIEW_CAPABILITY@IS_FIELD_CAPABILITY',
                        Capability::FIELD_CAPABILITY => 'View field "Is Field Capability" on a Capability',
                        Capability::FIELD_MIN_LEVEL => 3,
                    ],
                ],
                [
                    Capability::FIELD_ID => 7,
                    Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_CAPABILITY@ID',
                    Capability::FIELD_CAPABILITY => 'Change field "Id" on a Capability',
                    Capability::FIELD_MIN_LEVEL => 4,
                    Capability::FIELD_CRUD_FUNCTION => 'CHANGE',
                    Capability::FIELD_APPLICABLE_MODEL => 'Capabilities',
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
     * @param string $entity The entity being created
     * @param int $baseLevel The Base Level of the Entity Test
     * @param int $fieldCount The number of fields
     * @param array $expected Entities Created
     * @param array $hydrated First Entity
     * @return void
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

//        TestCase::assertEquals($expected, $query->disableHydration()->toArray());

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
            /*'Bad Model' => [
                'CREATE',
                'KASKDD',
                false,
            ],*/
            'View Field CAPABILITY_CODE' => [
                'VIEW',
                'Capabilities',
                'FIELD_VIEW_CAPABILITY@CAPABILITY_CODE',
                Capability::FIELD_CAPABILITY_CODE,
            ],
            'Bad Field Action' => [
                'MUSHROOM',
                'Capabilities',
                false,
                Capability::FIELD_CAPABILITY_CODE,
            ],
            /*'Bad Field Model' => [
                'VIEW',
                'KSOSAISA',
                false,
                Capability::FIELD_CAPABILITY_CODE,
            ],*/
        ];
    }

    /**
     * Test Build Capability Method and safety overloads
     *
     * @dataProvider providerBuildCapability
     * @param string $action Action being entered
     * @param string $model Model being entered
     * @param string|false $expected Expectation of result
     */
    public function testBuildCapability($action, $model, $expected, $field = null)
    {
        $result = $this->Capabilities->buildCapability($action, $model, $field);
        TestCase::assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function providerEnrichCapability()
    {
        return [
            'Complex Group Capability Array' => [
                [
                    'user' => [
                        36 => 'ALL',
                        79 => 'CREATE_SCOUT_GROUP',
                        51 => 'DELETE_SCOUT_GROUP',
                        50 => 'VIEW_SCOUT_GROUP',
                        34 => 'UPDATE_SCOUT_GROUP',
                        41 => 'FIELD_VIEW_USERS@LAST_LOGIN',
                        43 => 'FIELD_VIEW_USERS@LAST_LOGIN_IP',
                        46 => 'CREATE_USER',
                        49 => 'DELETE_USER',
                        20 => 'FIELD_VIEW_USERS@LAST_NAME',
                    ],
                    'group' => [
                        1 => [
                            70 => 'CREATE_SECTION',
                            23 => 'CREATE_USER',
                            47 => 'FIELD_CHANGE_USER@ADDRESS_LINE_1',
                            48 => 'FIELD_CHANGE_USER@ADDRESS_LINE_2',
                            56 => 'FIELD_CHANGE_USER@CAPABILITIES',
                            17 => 'FIELD_CHANGE_USER@CITY',
                            49 => 'FIELD_CHANGE_USER@COUNTY',
                            51 => 'FIELD_CHANGE_USER@CREATED',
                            45 => 'FIELD_CHANGE_USER@EMAIL',
                            43 => 'FIELD_CHANGE_USER@FIRST_NAME',
                            79 => 'FIELD_CHANGE_USER@FULL_NAME',
                            53 => 'FIELD_CHANGE_USER@LAST_LOGIN',
                            55 => 'FIELD_CHANGE_USER@LAST_LOGIN_IP',
                            44 => 'FIELD_CHANGE_USER@LAST_NAME',
                            42 => 'FIELD_CHANGE_USER@MEMBERSHIP_NUMBER',
                            52 => 'FIELD_CHANGE_USER@MODIFIED',
                            46 => 'FIELD_CHANGE_USER@PASSWORD',
                            57 => 'FIELD_CHANGE_USER@PASSWORD_STATE_ID',
                            50 => 'FIELD_CHANGE_USER@POSTCODE',
                            41 => 'FIELD_CHANGE_USER@USERNAME',
                            65 => 'FIELD_VIEW_USER@ADDRESS_LINE_1',
                            66 => 'FIELD_VIEW_USER@ADDRESS_LINE_2',
                            77 => 'FIELD_VIEW_USER@CAPABILITIES',
                            67 => 'FIELD_VIEW_USER@CITY',
                            68 => 'FIELD_VIEW_USER@COUNTY',
                            72 => 'FIELD_VIEW_USER@CREATED',
                            75 => 'FIELD_VIEW_USER@DELETED',
                            63 => 'FIELD_VIEW_USER@EMAIL',
                            61 => 'FIELD_VIEW_USER@FIRST_NAME',
                            80 => 'FIELD_VIEW_USER@FULL_NAME',
                            58 => 'FIELD_VIEW_USER@ID',
                            74 => 'FIELD_VIEW_USER@LAST_LOGIN',
                            71 => 'UPDATE_SECTION',
                            24 => 'UPDATE_USER',
                        ],
                        2 => [
                            70 => 'CREATE_SECTION',
                            23 => 'CREATE_USER',
                            71 => 'UPDATE_SECTION',
                        ],
                    ],
                ],
                [
                    'User' => [
                        'ScoutGroups' => [
                            'CREATE' => (int)79,
                            'DELETE' => (int)51,
                            'VIEW' => (int)50,
                            'UPDATE' => (int)34,
                        ],
                        'Users' => [
                            'fields' => [
                                'LAST_LOGIN' => [
                                    'VIEW' => (int)41,
                                ],
                                'LAST_LOGIN_IP' => [
                                    'VIEW' => (int)43,
                                ],
                                'LAST_NAME' => [
                                    'VIEW' => (int)20,
                                ],
                            ],
                            'CREATE' => (int)46,
                            'DELETE' => (int)49,
                        ],
                        'Special' => [
                            (int)36 => 'ALL',
                        ],
                    ],
                    'CRUD' => [
                        (int)0 => 'CREATE',
                        (int)1 => 'DELETE',
                        (int)2 => 'VIEW',
                        (int)3 => 'UPDATE',
                        (int)4 => 'CHANGE',
                    ],
                    'Group.1' => [
                        'Sections' => [
                            'CREATE' => (int)70,
                            'UPDATE' => (int)71,
                        ],
                        'Users' => [
                            'CREATE' => (int)23,
                            'fields' => [
                                'ADDRESS_LINE_1' => [
                                    'CHANGE' => (int)47,
                                    'VIEW' => (int)65,
                                ],
                                'ADDRESS_LINE_2' => [
                                    'CHANGE' => (int)48,
                                    'VIEW' => (int)66,
                                ],
                                'CAPABILITIES' => [
                                    'CHANGE' => (int)56,
                                    'VIEW' => (int)77,
                                ],
                                'CITY' => [
                                    'CHANGE' => (int)17,
                                    'VIEW' => (int)67,
                                ],
                                'COUNTY' => [
                                    'CHANGE' => (int)49,
                                    'VIEW' => (int)68,
                                ],
                                'CREATED' => [
                                    'CHANGE' => (int)51,
                                    'VIEW' => (int)72,
                                ],
                                'EMAIL' => [
                                    'CHANGE' => (int)45,
                                    'VIEW' => (int)63,
                                ],
                                'FIRST_NAME' => [
                                    'CHANGE' => (int)43,
                                    'VIEW' => (int)61,
                                ],
                                'FULL_NAME' => [
                                    'CHANGE' => (int)79,
                                    'VIEW' => (int)80,
                                ],
                                'LAST_LOGIN' => [
                                    'CHANGE' => (int)53,
                                    'VIEW' => (int)74,
                                ],
                                'LAST_LOGIN_IP' => [
                                    'CHANGE' => (int)55,
                                ],
                                'LAST_NAME' => [
                                    'CHANGE' => (int)44,
                                ],
                                'MEMBERSHIP_NUMBER' => [
                                    'CHANGE' => (int)42,
                                ],
                                'MODIFIED' => [
                                    'CHANGE' => (int)52,
                                ],
                                'PASSWORD' => [
                                    'CHANGE' => (int)46,
                                ],
                                'PASSWORD_STATE_ID' => [
                                    'CHANGE' => (int)57,
                                ],
                                'POSTCODE' => [
                                    'CHANGE' => (int)50,
                                ],
                                'USERNAME' => [
                                    'CHANGE' => (int)41,
                                ],
                                'DELETED' => [
                                    'VIEW' => (int)75,
                                ],
                                'ID' => [
                                    'VIEW' => (int)58,
                                ],
                            ],
                            'UPDATE' => (int)24,
                        ],
                        'Special' => [],
                    ],
                    'Group.2' => [
                        'Sections' => [
                            'CREATE' => (int)70,
                            'UPDATE' => (int)71,
                        ],
                        'Users' => [
                            'CREATE' => (int)23,
                        ],
                        'Special' => [],
                    ],
                ],
            ],
            'Complex Section Capability Array' => [
                [
                    'user' => [
                        36 => 'ALL',
                        79 => 'CREATE_SCOUT_GROUP',
                        51 => 'DELETE_SCOUT_GROUP',
                        50 => 'VIEW_SCOUT_GROUP',
                        34 => 'UPDATE_SCOUT_GROUP',
                        41 => 'FIELD_VIEW_USERS@LAST_LOGIN',
                        43 => 'FIELD_VIEW_USERS@LAST_LOGIN_IP',
                        46 => 'CREATE_USER',
                        49 => 'DELETE_USER',
                        20 => 'FIELD_VIEW_USERS@LAST_NAME',
                    ],
                    'section' => [
                        1 => [
                            70 => 'CREATE_SECTION',
                            23 => 'CREATE_USER',
                            47 => 'FIELD_CHANGE_USER@ADDRESS_LINE_1',
                            48 => 'FIELD_CHANGE_USER@ADDRESS_LINE_2',
                            56 => 'FIELD_CHANGE_USER@CAPABILITIES',
                            17 => 'FIELD_CHANGE_USER@CITY',
                            49 => 'FIELD_CHANGE_USER@COUNTY',
                            51 => 'FIELD_CHANGE_USER@CREATED',
                            45 => 'FIELD_CHANGE_USER@EMAIL',
                            43 => 'FIELD_CHANGE_USER@FIRST_NAME',
                            79 => 'FIELD_CHANGE_USER@FULL_NAME',
                            53 => 'FIELD_CHANGE_USER@LAST_LOGIN',
                            55 => 'FIELD_CHANGE_USER@LAST_LOGIN_IP',
                            44 => 'FIELD_CHANGE_USER@LAST_NAME',
                            42 => 'FIELD_CHANGE_USER@MEMBERSHIP_NUMBER',
                            52 => 'FIELD_CHANGE_USER@MODIFIED',
                            46 => 'FIELD_CHANGE_USER@PASSWORD',
                            57 => 'FIELD_CHANGE_USER@PASSWORD_STATE_ID',
                            50 => 'FIELD_CHANGE_USER@POSTCODE',
                            41 => 'FIELD_CHANGE_USER@USERNAME',
                            65 => 'FIELD_VIEW_USER@ADDRESS_LINE_1',
                            66 => 'FIELD_VIEW_USER@ADDRESS_LINE_2',
                            77 => 'FIELD_VIEW_USER@CAPABILITIES',
                            67 => 'FIELD_VIEW_USER@CITY',
                            68 => 'FIELD_VIEW_USER@COUNTY',
                            72 => 'FIELD_VIEW_USER@CREATED',
                            75 => 'FIELD_VIEW_USER@DELETED',
                            63 => 'FIELD_VIEW_USER@EMAIL',
                            61 => 'FIELD_VIEW_USER@FIRST_NAME',
                            80 => 'FIELD_VIEW_USER@FULL_NAME',
                            58 => 'FIELD_VIEW_USER@ID',
                            74 => 'FIELD_VIEW_USER@LAST_LOGIN',
                            71 => 'UPDATE_SECTION',
                            24 => 'UPDATE_USER',
                        ],
                        2 => [
                            70 => 'CREATE_SECTION',
                            23 => 'CREATE_USER',
                            71 => 'UPDATE_SECTION',
                        ],
                    ],
                ],
                [
                    'User' => [
                        'ScoutGroups' => [
                            'CREATE' => (int)79,
                            'DELETE' => (int)51,
                            'VIEW' => (int)50,
                            'UPDATE' => (int)34,
                        ],
                        'Users' => [
                            'fields' => [
                                'LAST_LOGIN' => [
                                    'VIEW' => (int)41,
                                ],
                                'LAST_LOGIN_IP' => [
                                    'VIEW' => (int)43,
                                ],
                                'LAST_NAME' => [
                                    'VIEW' => (int)20,
                                ],
                            ],
                            'CREATE' => (int)46,
                            'DELETE' => (int)49,
                        ],
                        'Special' => [
                            (int)36 => 'ALL',
                        ],
                    ],
                    'CRUD' => [
                        (int)0 => 'CREATE',
                        (int)1 => 'DELETE',
                        (int)2 => 'VIEW',
                        (int)3 => 'UPDATE',
                        (int)4 => 'CHANGE',
                    ],
                    'Section.1' => [
                        'Sections' => [
                            'CREATE' => (int)70,
                            'UPDATE' => (int)71,
                        ],
                        'Users' => [
                            'CREATE' => (int)23,
                            'fields' => [
                                'ADDRESS_LINE_1' => [
                                    'CHANGE' => (int)47,
                                    'VIEW' => (int)65,
                                ],
                                'ADDRESS_LINE_2' => [
                                    'CHANGE' => (int)48,
                                    'VIEW' => (int)66,
                                ],
                                'CAPABILITIES' => [
                                    'CHANGE' => (int)56,
                                    'VIEW' => (int)77,
                                ],
                                'CITY' => [
                                    'CHANGE' => (int)17,
                                    'VIEW' => (int)67,
                                ],
                                'COUNTY' => [
                                    'CHANGE' => (int)49,
                                    'VIEW' => (int)68,
                                ],
                                'CREATED' => [
                                    'CHANGE' => (int)51,
                                    'VIEW' => (int)72,
                                ],
                                'EMAIL' => [
                                    'CHANGE' => (int)45,
                                    'VIEW' => (int)63,
                                ],
                                'FIRST_NAME' => [
                                    'CHANGE' => (int)43,
                                    'VIEW' => (int)61,
                                ],
                                'FULL_NAME' => [
                                    'CHANGE' => (int)79,
                                    'VIEW' => (int)80,
                                ],
                                'LAST_LOGIN' => [
                                    'CHANGE' => (int)53,
                                    'VIEW' => (int)74,
                                ],
                                'LAST_LOGIN_IP' => [
                                    'CHANGE' => (int)55,
                                ],
                                'LAST_NAME' => [
                                    'CHANGE' => (int)44,
                                ],
                                'MEMBERSHIP_NUMBER' => [
                                    'CHANGE' => (int)42,
                                ],
                                'MODIFIED' => [
                                    'CHANGE' => (int)52,
                                ],
                                'PASSWORD' => [
                                    'CHANGE' => (int)46,
                                ],
                                'PASSWORD_STATE_ID' => [
                                    'CHANGE' => (int)57,
                                ],
                                'POSTCODE' => [
                                    'CHANGE' => (int)50,
                                ],
                                'USERNAME' => [
                                    'CHANGE' => (int)41,
                                ],
                                'DELETED' => [
                                    'VIEW' => (int)75,
                                ],
                                'ID' => [
                                    'VIEW' => (int)58,
                                ],
                            ],
                            'UPDATE' => (int)24,
                        ],
                        'Special' => [],
                    ],
                    'Section.2' => [
                        'Sections' => [
                            'CREATE' => (int)70,
                            'UPDATE' => (int)71,
                        ],
                        'Users' => [
                            'CREATE' => (int)23,
                        ],
                        'Special' => [],
                    ],
                ],
            ],
            'User Basic Array' => [
                [
                    'user' => [
                        36 => 'ALL',
                        79 => 'CREATE_SCOUT_GROUP',
                        51 => 'DELETE_SCOUT_GROUP',
                        50 => 'VIEW_SCOUT_GROUP',
                        34 => 'UPDATE_SCOUT_GROUP',
                        41 => 'FIELD_VIEW_USERS@LAST_LOGIN',
                        43 => 'FIELD_VIEW_USERS@LAST_LOGIN_IP',
                        46 => 'CREATE_USER',
                        49 => 'DELETE_USER',
                        20 => 'FIELD_VIEW_USERS@LAST_NAME',
                    ],
                ],
                [
                    'User' => [
                        'ScoutGroups' => [
                            'CREATE' => (int)79,
                            'DELETE' => (int)51,
                            'VIEW' => (int)50,
                            'UPDATE' => (int)34,
                        ],
                        'Users' => [
                            'fields' => [
                                'LAST_LOGIN' => [
                                    'VIEW' => (int)41,
                                ],
                                'LAST_LOGIN_IP' => [
                                    'VIEW' => (int)43,
                                ],
                                'LAST_NAME' => [
                                    'VIEW' => (int)20,
                                ],
                            ],
                            'CREATE' => (int)46,
                            'DELETE' => (int)49,
                        ],
                        'Special' => [
                            (int)36 => 'ALL',
                        ],
                    ],
                    'CRUD' => [
                        (int)0 => 'CREATE',
                        (int)1 => 'DELETE',
                        (int)2 => 'VIEW',
                        (int)3 => 'UPDATE',
                    ],
                ],
            ],
        ];
    }

    /**
     * Test Build Capability Method and safety overloads
     *
     * @dataProvider providerEnrichCapability
     * @param array $bare Array to be enriched
     * @param array $enriched Expected Result
     */
    public function testEnrichCapability($bare, $enriched)
    {
        $result = $this->Capabilities->enrichUserCapability($bare);

        TestCase::assertEquals($enriched, $result);
    }

    /**
     * @return array
     */
    public function providerEnrichRoleType()
    {
        return [
            'Complex Group Capability Array' => [
                [],
                [],
            ],
        ];
    }

    /**
     * Test Build Capability Method and safety overloads
     *
     * @dataProvider providerEnrichRoleType
     * @param array $bare Array to be enriched
     * @param array $enriched Expected Result
     */
    public function testEnrichRoleType($bare, $enriched)
    {
        $result = $this->Capabilities->enrichUserCapability($bare);

        TestCase::assertEquals($enriched, $result);
    }

    /**
     * @return array
     */
    public function providerGetSplitLists()
    {
        return [
            'Standard' => [
                [
                    'Special' => [
                        'ALL' => 'SuperUser Permissions',
                        'OWN_USER' => 'Edit Own User',
                        'LOGIN' => 'Login',
                    ],
                    'Entity' => [
                        'EDIT_GROUP' => 'Edit Group',
                        'EDIT_SECT' => 'Edit Section',
                        'EDIT_USER' => 'Edit User',
                    ],
                    'Field' => [],
                ],
                false,
            ],
            'Installed' => [
                [
                    'Special' => [
                        'ALL' => 'SuperUser Permissions',
                        'OWN_USER' => 'Edit Own User',
                        'LOGIN' => 'Login',
                        'DIRECTORY' => 'Use the District Directory',
                    ],
                    'Entity' => [
                        'EDIT_GROUP' => 'Edit Group',
                        'EDIT_SECT' => 'Edit Section',
                        'EDIT_USER' => 'Edit User',
                        'CREATE_USER' => 'Create a User',
                        'UPDATE_USER' => 'Update a User',
                        'VIEW_USER' => 'View a User',
                        'DELETE_USER' => 'Delete a User',
                        'CREATE_SCOUT_GROUP' => 'Create a Scout Group',
                        'UPDATE_SCOUT_GROUP' => 'Update a Scout Group',
                        'VIEW_SCOUT_GROUP' => 'View a Scout Group',
                        'DELETE_SCOUT_GROUP' => 'Delete a Scout Group',
                        'CREATE_SECTION' => 'Create a Section',
                        'UPDATE_SECTION' => 'Update a Section',
                        'VIEW_SECTION' => 'View a Section',
                        'DELETE_SECTION' => 'Delete a Section',
                        'CREATE_ROLE_TYPE' => 'Create a Role Type',
                        'UPDATE_ROLE_TYPE' => 'Update a Role Type',
                        'VIEW_ROLE_TYPE' => 'View a Role Type',
                        'DELETE_ROLE_TYPE' => 'Delete a Role Type',
                        'CREATE_DOCUMENT' => 'Create a Document',
                        'UPDATE_DOCUMENT' => 'Update a Document',
                        'VIEW_DOCUMENT' => 'View a Document',
                        'DELETE_DOCUMENT' => 'Delete a Document',
                    ],
                    'Field' => [
                        'FIELD_CHANGE_USER@ID' => 'Change field "Id" on a User',
                        'FIELD_CHANGE_USER@USERNAME' => 'Change field "Username" on a User',
                        'FIELD_CHANGE_USER@MEMBERSHIP_NUMBER' => 'Change field "Membership Number" on a User',
                        'FIELD_CHANGE_USER@FIRST_NAME' => 'Change field "First Name" on a User',
                        'FIELD_CHANGE_USER@LAST_NAME' => 'Change field "Last Name" on a User',
                        'FIELD_CHANGE_USER@EMAIL' => 'Change field "Email" on a User',
                        'FIELD_CHANGE_USER@ADDRESS_LINE_1' => 'Change field "Address Line 1" on a User',
                        'FIELD_CHANGE_USER@ADDRESS_LINE_2' => 'Change field "Address Line 2" on a User',
                        'FIELD_CHANGE_USER@CITY' => 'Change field "City" on a User',
                        'FIELD_CHANGE_USER@COUNTY' => 'Change field "County" on a User',
                        'FIELD_CHANGE_USER@POSTCODE' => 'Change field "Postcode" on a User',
                        'FIELD_CHANGE_USER@CREATED' => 'Change field "Created" on a User',
                        'FIELD_CHANGE_USER@MODIFIED' => 'Change field "Modified" on a User',
                        'FIELD_CHANGE_USER@LAST_LOGIN' => 'Change field "Last Login" on a User',
                        'FIELD_CHANGE_USER@DELETED' => 'Change field "Deleted" on a User',
                        'FIELD_CHANGE_USER@LAST_LOGIN_IP' => 'Change field "Last Login Ip" on a User',
                        'FIELD_CHANGE_USER@CAPABILITIES' => 'Change field "Capabilities" on a User',
                        'FIELD_CHANGE_USER@USER_STATE_ID' => 'Change field "User State Id" on a User',
                        'FIELD_CHANGE_USER@FULL_NAME' => 'Change field "Full Name" on a User',
                        'FIELD_VIEW_USER@ID' => 'View field "Id" on a User',
                        'FIELD_VIEW_USER@USERNAME' => 'View field "Username" on a User',
                        'FIELD_VIEW_USER@MEMBERSHIP_NUMBER' => 'View field "Membership Number" on a User',
                        'FIELD_VIEW_USER@FIRST_NAME' => 'View field "First Name" on a User',
                        'FIELD_VIEW_USER@LAST_NAME' => 'View field "Last Name" on a User',
                        'FIELD_VIEW_USER@EMAIL' => 'View field "Email" on a User',
                        'FIELD_VIEW_USER@ADDRESS_LINE_1' => 'View field "Address Line 1" on a User',
                        'FIELD_VIEW_USER@ADDRESS_LINE_2' => 'View field "Address Line 2" on a User',
                        'FIELD_VIEW_USER@CITY' => 'View field "City" on a User',
                        'FIELD_VIEW_USER@COUNTY' => 'View field "County" on a User',
                        'FIELD_VIEW_USER@POSTCODE' => 'View field "Postcode" on a User',
                        'FIELD_VIEW_USER@CREATED' => 'View field "Created" on a User',
                        'FIELD_VIEW_USER@MODIFIED' => 'View field "Modified" on a User',
                        'FIELD_VIEW_USER@LAST_LOGIN' => 'View field "Last Login" on a User',
                        'FIELD_VIEW_USER@DELETED' => 'View field "Deleted" on a User',
                        'FIELD_VIEW_USER@LAST_LOGIN_IP' => 'View field "Last Login Ip" on a User',
                        'FIELD_VIEW_USER@CAPABILITIES' => 'View field "Capabilities" on a User',
                        'FIELD_VIEW_USER@USER_STATE_ID' => 'View field "User State Id" on a User',
                        'FIELD_VIEW_USER@FULL_NAME' => 'View field "Full Name" on a User',
                    ],
                ],
                true,
            ],
        ];
    }

    /**
     * Test Build Capability Method and safety overloads
     *
     * @dataProvider providerGetSplitLists
     * @param array $expected Expected Result
     * @param bool $installBase Whether to Install Base Capabilities
     */
    public function testGetSplitLists($expected, $installBase)
    {
        if ($installBase) {
            $this->Capabilities->installBaseCapabilities();
        }
        $result = $this->Capabilities->getSplitLists();

        TestCase::assertEquals($expected, $result);
    }
}
