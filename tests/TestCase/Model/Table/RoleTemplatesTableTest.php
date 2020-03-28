<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\RoleTemplate;
use App\Model\Table\RoleTemplatesTable;
use Cake\Event\EventList;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RoleTemplatesTable Test Case
 *
 * @property EventManager $EventManager
 */
class RoleTemplatesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\RoleTemplatesTable
     */
    public $RoleTemplates;

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
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RoleTemplates') ? [] : ['className' => RoleTemplatesTable::class];
        $this->RoleTemplates = TableRegistry::getTableLocator()->get('RoleTemplates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->RoleTemplates);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     *
     * @throws
     */
    private function getGood()
    {
        return [
            RoleTemplate::FIELD_ROLE_TEMPLATE => 'Template ' . random_int(1, 999) . random_int(1, 99),
            RoleTemplate::FIELD_INDICATIVE_LEVEL => 2,
            RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => [],
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
            RoleTemplate::FIELD_ID => 1,
            RoleTemplate::FIELD_ROLE_TEMPLATE => 'Lorem ipsum dolor sit amet',
            RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => '',
            RoleTemplate::FIELD_INDICATIVE_LEVEL => 1,
        ];
        $this->validateInitialise($expected, $this->RoleTemplates, 1);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->RoleTemplates->newEntity($good);
        TestCase::assertInstanceOf($this->RoleTemplates->getEntityClass(), $this->RoleTemplates->save($new));

        $required = [
            RoleTemplate::FIELD_ROLE_TEMPLATE,
            RoleTemplate::FIELD_INDICATIVE_LEVEL,
            RoleTemplate::FIELD_TEMPLATE_CAPABILITIES,
        ];
        $this->validateRequired($required, $this->RoleTemplates, [$this, 'getGood']);

        $notEmpties = [
            RoleTemplate::FIELD_ROLE_TEMPLATE,
            RoleTemplate::FIELD_INDICATIVE_LEVEL,
        ];
        $this->validateNotEmpties($notEmpties, $this->RoleTemplates, [$this, 'getGood']);

        $empties = [
            RoleTemplate::FIELD_TEMPLATE_CAPABILITIES,
        ];
        $this->validateEmpties($empties, $this->RoleTemplates, [$this, 'getGood']);

        $maxLengths = [
            RoleTemplate::FIELD_ROLE_TEMPLATE => 63,
        ];
        $this->validateMaxLengths($maxLengths, $this->RoleTemplates, [$this, 'getGood']);
    }

    /**
     * Test beforeSave method
     *
     * @return void
     */
    public function testBeforeSave()
    {
        // New Entity
        $this->EventManager = $this->RoleTemplates->getEventManager();
        $this->EventManager->setEventList(new EventList());

        $entity = $this->RoleTemplates->newEntity($this->getGood());
        $this->RoleTemplates->save($entity);

        TestCase::assertInstanceOf('App\Model\Table\RoleTemplatesTable', $this->EventManager->matchingListeners('Model.beforeSave')['Model.beforeSave'][10][0]['callable'][0]);

        $this->assertEventFired('Model.beforeSave', $this->EventManager);
        $this->assertEventFiredWith('Model.RoleTemplates.templateChange', 'role_template', $entity, $this->EventManager);

        // Modified Entity
        $this->EventManager = $this->RoleTemplates->getEventManager();
        $this->EventManager->setEventList(new EventList());

        $caps = $entity->get(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES);
        array_push($caps, 'ADD_USER');
        $entity->set(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, $caps);
        $this->RoleTemplates->save($entity);

        $this->assertEventFired('Model.beforeSave', $this->EventManager);
        $this->assertEventFiredWith('Model.RoleTemplates.templateChange', 'role_template', $entity, $this->EventManager);

        // Dirty Entity
        $this->EventManager = $this->RoleTemplates->getEventManager();
        $this->EventManager->setEventList(new EventList());

        $entity->setDirty(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES);
        $this->RoleTemplates->save($entity);

        $this->assertEventFired('Model.beforeSave', $this->EventManager);
        $this->assertEventFiredWith('Model.RoleTemplates.templateChange', 'role_template', $entity, $this->EventManager);
    }

    /**
     * @return array
     */
    public function providerMakeCoreTemplate()
    {
        return [
            'Level 0' => [
                'Restricted',
                0,
                [
                    RoleTemplate::FIELD_ID => 2,
                    RoleTemplate::FIELD_INDICATIVE_LEVEL => 0,
                    RoleTemplate::FIELD_ROLE_TEMPLATE => 'Restricted',
                    RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => ['LOGIN'],
                ],
            ],
            'Level 1' => [
                'Standard',
                1,
                [
                    RoleTemplate::FIELD_ID => 2,
                    RoleTemplate::FIELD_INDICATIVE_LEVEL => 1,
                    RoleTemplate::FIELD_ROLE_TEMPLATE => 'Standard',
                    RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => ['OWN_USER', 'LOGIN'],
                ],
            ],
            'Level 2' => [
                'Section',
                2,
                [
                    RoleTemplate::FIELD_ID => 2,
                    RoleTemplate::FIELD_INDICATIVE_LEVEL => 2,
                    RoleTemplate::FIELD_ROLE_TEMPLATE => 'Section',
                    RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => ['EDIT_USER', 'OWN_USER', 'LOGIN'],
                ],
            ],
            'Level 3' => [
                'Group',
                3,
                [
                    RoleTemplate::FIELD_ID => 2,
                    RoleTemplate::FIELD_INDICATIVE_LEVEL => 3,
                    RoleTemplate::FIELD_ROLE_TEMPLATE => 'Group',
                    RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => ['EDIT_SECT', 'EDIT_USER', 'OWN_USER', 'LOGIN'],
                ],
            ],
            'Level 4' => [
                'District',
                4,
                [
                    RoleTemplate::FIELD_ID => 2,
                    RoleTemplate::FIELD_INDICATIVE_LEVEL => 4,
                    RoleTemplate::FIELD_ROLE_TEMPLATE => 'District',
                    RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => ['EDIT_GROUP', 'EDIT_SECT', 'EDIT_USER', 'OWN_USER', 'LOGIN'],
                ],
            ],
            'Level 5' => [
                'God Access',
                5,
                [
                    RoleTemplate::FIELD_ID => 2,
                    RoleTemplate::FIELD_INDICATIVE_LEVEL => 5,
                    RoleTemplate::FIELD_ROLE_TEMPLATE => 'God Access',
                    RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => ['ALL', 'EDIT_GROUP', 'EDIT_SECT', 'EDIT_USER', 'OWN_USER', 'LOGIN'],
                ],
            ],
            'No Level' => [
                'No Level',
                null,
                false,
            ],
            'Bad Level' => [
                'Bad Level',
                'Goat',
                false,
            ],
        ];
    }

    /**
     * @param array $entity Array to be split
     * @param string $key Key to split on
     * @param string $prefix for the Array
     *
     * @return array
     */
    private function splitArray($entity, $key, $prefix)
    {
        $capabilities = $entity[$key];
        unset($entity[$key]);

        return [
            $prefix . 'Capabilities' => $capabilities,
            $prefix . 'Entity' => $entity,
        ];
    }

    /**
     * Test makeCoreTemplate method
     *
     * @dataProvider providerMakeCoreTemplate
     *
     * @param string $name The Name for the Template
     * @param int $level The Level for the core
     * @param array $expected Expected array as created
     *
     * @return void
     */
    public function testMakeCoreTemplate($name, $level, $expected)
    {
        $template = $this->RoleTemplates->makeCoreTemplate($name, $level);

        if (!is_bool($expected) && $expected) {
            $actualCapabilities = [];
            $actualEntity = [];
            extract($this->splitArray($template->toArray(), RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, 'actual'), EXTR_OVERWRITE);

            $expectedCapabilities = [];
            $expectedEntity = [];
            extract($this->splitArray($expected, RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, 'expected'), EXTR_OVERWRITE);

            foreach ($expectedCapabilities as $expectedCapability) {
                TestCase::assertTrue(in_array($expectedCapability, $actualCapabilities));
            }

            foreach ($actualCapabilities as $actualCapability) {
                TestCase::assertTrue(in_array($actualCapability, $expectedCapabilities));
            }

            TestCase::assertEquals($expectedEntity, $actualEntity);
        } else {
            TestCase::assertFalse($template);
        }
    }

    /**
     * Test Role Template install
     */
    public function testInstallBaseRoleTemplates()
    {
        $this->validateInstallBase($this->RoleTemplates);
    }

    /**
     * @return array
     */
    public function providerInstallBaseRoleTemplate()
    {
        return [
            'Level 0' => [
                [
                    'template_name' => 'Restricted',
                    'core_level' => 0,
                ],
                [
                    RoleTemplate::FIELD_ID => 2,
                    RoleTemplate::FIELD_INDICATIVE_LEVEL => 0,
                    RoleTemplate::FIELD_ROLE_TEMPLATE => 'Restricted',
                    RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => [
                        'LOGIN',
                    ],
                ],
            ],
            'Level 1' => [
                [
                    'template_name' => 'Standard',
                    'core_level' => 1,
                ],
                [
                    RoleTemplate::FIELD_ID => 2,
                    RoleTemplate::FIELD_INDICATIVE_LEVEL => 1,
                    RoleTemplate::FIELD_ROLE_TEMPLATE => 'Standard',
                    RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => [
                        'OWN_USER',
                        'LOGIN',
                    ],
                ],
            ],
            'Level 2' => [
                [
                    'template_name' => 'Section',
                    'core_level' => 2,
                ],
                [
                    RoleTemplate::FIELD_ID => 2,
                    RoleTemplate::FIELD_INDICATIVE_LEVEL => 2,
                    RoleTemplate::FIELD_ROLE_TEMPLATE => 'Section',
                    RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => [
                        'EDIT_USER',
                        'OWN_USER',
                        'LOGIN',
                    ],
                ],
            ],
            'Level 5' => [
                [
                    'template_name' => 'Digital Admin',
                    'core_level' => 5,
                ],
                [
                    RoleTemplate::FIELD_ID => 2,
                    RoleTemplate::FIELD_INDICATIVE_LEVEL => 5,
                    RoleTemplate::FIELD_ROLE_TEMPLATE => 'Digital Admin',
                    RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => [
                        'ALL',
                        'EDIT_GROUP',
                        'EDIT_SECT',
                        'EDIT_USER',
                        'OWN_USER',
                        'LOGIN',
                    ],
                ],
            ],
            'No Level' => [
                [
                    'template_name' => 'Digital Admin',
                ],
                false,
            ],
            'No Name' => [
                [
                    'core_level' => 5,
                ],
                false,
            ],
            'Capability Specified' => [
                [
                    'template_name' => 'Exec',
                    'core_level' => 2,
                    'capabilities' => [
                        'CREATE_USER',
                    ],
                ],
                [
                    RoleTemplate::FIELD_ID => 2,
                    RoleTemplate::FIELD_INDICATIVE_LEVEL => 2,
                    RoleTemplate::FIELD_ROLE_TEMPLATE => 'Exec',
                    RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => [
                        'CREATE_USER',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerInstallBaseRoleTemplate
     *
     * @param array $roleTemplate The Input from config
     * @param array|false $expected The Role Template to be created
     */
    public function testInstallBaseRoleTemplate($roleTemplate, $expected)
    {
        $result = $this->RoleTemplates->installBaseRoleTemplate($roleTemplate);

        if (!$expected) {
            TestCase::assertEquals($expected, $result);
        }

        if ($expected) {
            $result = $this->RoleTemplates->get(2)->toArray();
            $actualCapabilities = [];
            $actualEntity = [];
            extract($this->splitArray($result, RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, 'actual'));

            $expectedCapabilities = [];
            $expectedEntity = [];
            extract($this->splitArray($expected, RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, 'expected'));

            foreach ($expectedCapabilities as $expectedCapability) {
                TestCase::assertTrue(in_array($expectedCapability, $actualCapabilities));
            }

            foreach ($actualCapabilities as $actualCapability) {
                TestCase::assertTrue(in_array($actualCapability, $expectedCapabilities));
            }

            TestCase::assertEquals($expectedEntity, $actualEntity);
        }
    }
}
