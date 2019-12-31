<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\RoleTemplate;
use App\Model\Entity\RoleType;
use App\Model\Table\RoleTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RoleTypesTable Test Case
 */
class RoleTypesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\RoleTypesTable
     */
    public $RoleTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PasswordStates',
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
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RoleTypes') ? [] : ['className' => RoleTypesTable::class];
        $this->RoleTypes = TableRegistry::getTableLocator()->get('RoleTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RoleTypes);

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
            RoleType::FIELD_ROLE_TYPE => 'My Role ' . random_int(1, 999) . random_int(1, 99),
            RoleType::FIELD_ROLE_ABBREVIATION => 'Go Go' . random_int(1, 999) . random_int(1, 99),
            RoleType::FIELD_SECTION_TYPE_ID => 1,
            RoleType::FIELD_LEVEL => 1,
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
            RoleType::FIELD_ID => 1,
            RoleType::FIELD_ROLE_TYPE => 'Lorem ipsum dolor sit amet',
            RoleType::FIELD_ROLE_ABBREVIATION => 'Lorem ipsum dolor sit amet',
            RoleType::FIELD_SECTION_TYPE_ID => 1,
            RoleType::FIELD_LEVEL => 1,
            RoleType::FIELD_ROLE_TEMPLATE_ID => 1,
        ];

        $this->validateInitialise($expected, $this->RoleTypes, 7);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->RoleTypes->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\RoleType', $this->RoleTypes->save($new));

        $required = [
            RoleType::FIELD_ROLE_TYPE,
            RoleType::FIELD_LEVEL,
        ];

        $this->validateRequired($required, $this->RoleTypes, [$this, 'getGood']);

        $notRequired = [
            RoleType::FIELD_ROLE_ABBREVIATION,
        ];

        $this->validateNotRequired($notRequired, $this->RoleTypes, [$this, 'getGood']);

        $empties = [
            RoleType::FIELD_ROLE_ABBREVIATION,
        ];

        $this->validateEmpties($empties, $this->RoleTypes, [$this, 'getGood']);

        $notEmpties = [
            RoleType::FIELD_ROLE_TYPE,
            RoleType::FIELD_LEVEL,
        ];

        $this->validateNotEmpties($notEmpties, $this->RoleTypes, [$this, 'getGood']);

        $maxLengths = [
            RoleType::FIELD_ROLE_TYPE => 255,
            RoleType::FIELD_ROLE_ABBREVIATION => 32,
        ];

        $this->validateMaxLengths($maxLengths, $this->RoleTypes, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $foreignKeys = [
            RoleType::FIELD_SECTION_TYPE_ID => $this->RoleTypes->SectionTypes,
            RoleType::FIELD_ROLE_TEMPLATE_ID => $this->RoleTypes->RoleTemplates,
        ];
        $this->validateExistsRules($foreignKeys, $this->RoleTypes, [$this, 'getGood']);

        $uniques = [
            RoleType::FIELD_ROLE_ABBREVIATION,
            RoleType::FIELD_ROLE_TYPE,
        ];
        $this->validateUniqueRules($uniques, $this->RoleTypes, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testPatchAllTemplateCapabilities()
    {
        $roleTypeOriginal = $this->RoleTypes->get(1, ['contain' => ['Capabilities']]);
        $roleType = $this->RoleTypes->patchTemplateCapabilities($roleTypeOriginal);
        TestCase::assertInstanceOf(RoleType::class, $this->RoleTypes->save($roleType));

        $roleType = $this->RoleTypes->get(1, ['contain' => ['Capabilities']]);
        TestCase::assertNotSame($roleTypeOriginal->capabilities, $roleType->capabilities);

        $expectedCaps = [
            'LOGIN' => true,
            'OWN_USER' => true,
        ];

        foreach ($roleType->capabilities as $capability) {
            TestCase::assertTrue(key_exists($capability->capability_code, $expectedCaps));
            TestCase::assertSame($capability->_joinData->template, $expectedCaps[$capability->capability_code]);
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testPatchTemplateCapabilities()
    {
        $roleTemplate = $this->RoleTypes->RoleTemplates->get(1);
        $roleTemplate->set(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, ['DIRECTORY', 'DELETE_USER']);
        $roleTemplate = $this->RoleTypes->RoleTemplates->save($roleTemplate);
        TestCase::assertInstanceOf($this->RoleTypes->RoleTemplates->getEntityClass(), $roleTemplate);

        $roleTypeOriginal = $this->RoleTypes->get(1, ['contain' => ['Capabilities']]);
        $roleType = $this->RoleTypes->patchTemplateCapabilities($roleTypeOriginal);
        TestCase::assertInstanceOf(RoleType::class, $this->RoleTypes->save($roleType));

        $roleType = $this->RoleTypes->get(1, ['contain' => ['Capabilities']]);
        TestCase::assertNotSame($roleTypeOriginal->capabilities, $roleType->capabilities);

        $expectedCaps = [
            'LOGIN' => true,
            'OWN_USER' => true,
            'DIRECTORY' => true,
            'DELETE_USER' => true,
        ];

        foreach ($roleType->capabilities as $capability) {
            TestCase::assertTrue(key_exists($capability->capability_code, $expectedCaps));
            TestCase::assertSame($capability->_joinData->template, $expectedCaps[$capability->capability_code]);
        }
    }
}
