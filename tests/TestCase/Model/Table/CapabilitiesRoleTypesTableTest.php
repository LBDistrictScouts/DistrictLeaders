<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\CapabilitiesRoleType;
use App\Model\Entity\Capability;
use App\Model\Entity\RoleType;
use App\Model\Table\CapabilitiesRoleTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CapabilitiesRoleTypesTable Test Case
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class CapabilitiesRoleTypesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var CapabilitiesRoleTypesTable
     */
    public $CapabilitiesRoleTypes;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CapabilitiesRoleTypes') ? [] : ['className' => CapabilitiesRoleTypesTable::class];
        $this->CapabilitiesRoleTypes = $this->getTableLocator()->get('CapabilitiesRoleTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CapabilitiesRoleTypes);

        parent::tearDown();
    }

    /**
     * Function to Create Good Entity Data
     *
     * @return array
     */
    protected function getGood()
    {
        $newCapData = (new CapabilitiesTableTest())->getGood();
        $newCap = $this->CapabilitiesRoleTypes->Capabilities->newEntity($newCapData);
        $newCap = $this->CapabilitiesRoleTypes->Capabilities->save($newCap);

//        debug($newCap);

        $newRoleTypeData = (new RoleTypesTableTest())->getGood();
        $newRoleType = $this->CapabilitiesRoleTypes->RoleTypes->newEntity($newRoleTypeData);
        $newRoleType = $this->CapabilitiesRoleTypes->RoleTypes->save($newRoleType);

//        debug($newRoleType);

        return [
            CapabilitiesRoleType::FIELD_CAPABILITY_ID => $newCap->get(Capability::FIELD_ID),
            CapabilitiesRoleType::FIELD_ROLE_TYPE_ID => $newRoleType->get(RoleType::FIELD_ID),
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
            CapabilitiesRoleType::FIELD_CAPABILITY_ID => 1,
            CapabilitiesRoleType::FIELD_ROLE_TYPE_ID => 5,
            CapabilitiesRoleType::FIELD_TEMPLATE => false,
        ];
        $this->validateInitialise($expected, $this->CapabilitiesRoleTypes, 10, null, $expected);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->validateExistsRule(CapabilitiesRoleType::FIELD_ROLE_TYPE_ID, $this->CapabilitiesRoleTypes, $this->CapabilitiesRoleTypes->RoleTypes, [$this, 'getGood'], ['fields' => ['capability_id', 'role_type_id']]);

        $this->validateExistsRule(CapabilitiesRoleType::FIELD_ROLE_TYPE_ID, $this->CapabilitiesRoleTypes, $this->CapabilitiesRoleTypes->RoleTypes, [$this, 'getGood'], ['fields' => ['capability_id', 'role_type_id']]);
    }
}
