<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Capability;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Capability Test Case
 */
class CapabilityTest extends TestCase
{
    /**
     * Test subject
     *
     * @var Capability
     */
    public $Capability;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->Capability = new Capability([
            Capability::FIELD_CAPABILITY_CODE => 'CREATE_SCOUT_GROUP',
            Capability::FIELD_CAPABILITY => 'Create Scout Group',
            Capability::FIELD_MIN_LEVEL => 2,
        ]);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Capability);

        parent::tearDown();
    }

    /**
     * Test _getCrudFunction method
     *
     * @return void
     */
    public function testGetCrudFunction()
    {
        $fieldValue = $this->Capability->get(Capability::FIELD_CRUD_FUNCTION);
        TestCase::assertSame('CREATE', $fieldValue);

        $this->Capability = new Capability([
            Capability::FIELD_CAPABILITY_CODE => 'LOGIN',
            Capability::FIELD_CAPABILITY => 'Login to system',
            Capability::FIELD_MIN_LEVEL => 1,
        ]);
        $fieldValue = $this->Capability->get(Capability::FIELD_CRUD_FUNCTION);
        TestCase::assertSame('SPECIAL', $fieldValue);

        $this->Capability = new Capability([
            Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_SCOUT_GROUP@GROUP_ALIAS',
            Capability::FIELD_CAPABILITY => 'Update Field Group Alias on Scout Group',
            Capability::FIELD_MIN_LEVEL => 1,
        ]);
        $fieldValue = $this->Capability->get(Capability::FIELD_CRUD_FUNCTION);
        TestCase::assertSame('CHANGE', $fieldValue);
    }

    /**
     * Test _getApplicableModel method
     *
     * @return void
     */
    public function testGetApplicableModel()
    {
        $fieldValue = $this->Capability->get(Capability::FIELD_APPLICABLE_MODEL);
        TestCase::assertSame('ScoutGroups', $fieldValue);

        $this->Capability = new Capability([
            Capability::FIELD_CAPABILITY_CODE => 'LOGIN',
            Capability::FIELD_CAPABILITY => 'Login to system',
            Capability::FIELD_MIN_LEVEL => 1,
        ]);
        $fieldValue = $this->Capability->get(Capability::FIELD_APPLICABLE_MODEL);
        TestCase::assertSame('SPECIAL', $fieldValue);

        $this->Capability = new Capability([
            Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_SCOUT_GROUP@GROUP_ALIAS',
            Capability::FIELD_CAPABILITY => 'Update Field Group Alias on Scout Group',
            Capability::FIELD_MIN_LEVEL => 1,
        ]);
        $fieldValue = $this->Capability->get(Capability::FIELD_APPLICABLE_MODEL);
        TestCase::assertSame('ScoutGroups', $fieldValue);
    }

    /**
     * Test _getIsFieldCapability method
     *
     * @return void
     */
    public function testGetIsFieldCapability()
    {
        $fieldValue = $this->Capability->get(Capability::FIELD_IS_FIELD_CAPABILITY);
        TestCase::assertFalse($fieldValue);

        $this->Capability = new Capability([
            Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_SCOUT_GROUP@GROUP_ALIAS',
            Capability::FIELD_CAPABILITY => 'Update Field Group Alias on Scout Group',
            Capability::FIELD_MIN_LEVEL => 1,
        ]);
        $fieldValue = $this->Capability->get(Capability::FIELD_IS_FIELD_CAPABILITY);
        TestCase::assertTrue($fieldValue);
    }

    /**
     * Test _getIsFieldCapability method
     *
     * @return void
     */
    public function testGetApplicableField()
    {
        $fieldValue = $this->Capability->get(Capability::FIELD_APPLICABLE_FIELD);
        TestCase::assertFalse($fieldValue);

        $this->Capability = new Capability([
            Capability::FIELD_CAPABILITY_CODE => 'FIELD_CHANGE_SCOUT_GROUP@GROUP_ALIAS',
            Capability::FIELD_CAPABILITY => 'Update Field Group Alias on Scout Group',
            Capability::FIELD_MIN_LEVEL => 1,
        ]);
        $fieldValue = $this->Capability->get(Capability::FIELD_APPLICABLE_FIELD);
        TestCase::assertSame('GROUP_ALIAS', $fieldValue);
    }
}
