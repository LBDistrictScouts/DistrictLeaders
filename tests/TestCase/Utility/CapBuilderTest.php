<?php
declare(strict_types=1);

namespace App\Test\TestCase\Utility;

use App\Model\Entity\RoleTemplate;
use App\Model\Entity\ScoutGroup;
use App\Model\Entity\User;
use App\Utility\CapBuilder;
use Cake\TestSuite\TestCase;

/**
 * Class TextSafeTest
 *
 * @package App\Test\TestCase\Utility
 */
class CapBuilderTest extends TestCase
{
    /**
     * @return array
     */
    public function providerIsFieldType()
    {
        return [
            'Is Field' => [
                'FIELD_VIEW_CA',
                true,
            ],
            'Is Not Field' => [
                'CREATE_MUSHROOM',
                false,
            ],
            'Is Empty' => [
                '',
                false,
            ],
        ];
    }

    /**
     * Test decode()
     *
     * @param string $capability The Capability String
     * @param bool $expected The length of the expected string
     * @dataProvider providerIsFieldType
     * @return void
     */
    public function testIsFieldType($capability, $expected)
    {
        TestCase::assertEquals($expected, CapBuilder::isFieldType($capability));
    }

    /**
     * @return array
     */
    public function providerIsFieldActionType()
    {
        return [
            'Is Field Action Type' => [
                'CHANGE',
                true,
            ],
            'Is Other Action Type' => [
                'UPDATE',
                false,
            ],
            'Is Not Action Type' => [
                'GOAT',
                false,
            ],
            'Is Empty' => [
                '',
                false,
            ],
        ];
    }

    /**
     * Test decode()
     *
     * @param string $action The Capability String
     * @param bool $expected The length of the expected string
     * @dataProvider providerIsFieldActionType
     * @return void
     */
    public function testIsFieldActionType($action, $expected)
    {
        TestCase::assertEquals($expected, CapBuilder::isFieldActionType($action));
    }

    /**
     * @return array
     */
    public function providerCapabilityCodeFormat()
    {
        return [
            'Valid View Field' => [
                'FIELD_VIEW_USER@EMAIL',
                'VIEW',
                'Users',
                User::FIELD_EMAIL,
            ],
            'Valid Change Field' => [
                'FIELD_CHANGE_USER@EMAIL',
                'CHANGE',
                'Users',
                User::FIELD_EMAIL,
            ],
            'Valid View 2Part Field' => [
                'FIELD_VIEW_ROLE_TEMPLATE@TEMPLATE_CAPABILITIES',
                'VIEW',
                'RoleTemplates',
                RoleTemplate::FIELD_TEMPLATE_CAPABILITIES,
            ],
            'Valid Change 2Part Field' => [
                'FIELD_CHANGE_SCOUT_GROUP@CLEAN_DOMAIN',
                'CHANGE',
                'ScoutGroups',
                ScoutGroup::FIELD_CLEAN_DOMAIN,
            ],
            'Invalid Action Field' => [
                false,
                'GOAT', // Invalid
                'Users',
                User::FIELD_EMAIL,
            ],
            'Wrong Action Field' => [
                false,
                'UPDATE', // Entity Action
                'Users',
                User::FIELD_EMAIL,
            ],
            'Valid View Entity' => [
                'VIEW_ROLE_TEMPLATE',
                'VIEW',
                'RoleTemplates',
            ],
            'Valid Change Entity' => [
                'UPDATE_SCOUT_GROUP',
                'UPDATE',
                'ScoutGroups',
            ],
            'Invalid Action Entity' => [
                false,
                'GOAT', // Invalid
                'Users',
            ],
            'Wrong Action Entity' => [
                false,
                'CHANGE', // Field Action
                'Users',
            ],
        ];
    }

    /**
     * @param string $expected Outcome expected
     * @param string $action The name of the Action performed
     * @param string $model The Model generated
     * @param string|null $field The Field being limited
     * @dataProvider providerCapabilityCodeFormat
     * @return string
     */
    public static function testCapabilityCodeFormat($expected, $action, $model, $field = null)
    {
        TestCase::assertEquals($expected, CapBuilder::capabilityCodeFormat($action, $model, $field));
    }

    /**
     * @return array
     */
    public function providerCapabilityNameFormat()
    {
        return [
            'Valid View Field' => [
                'View field "Email" on a User',
                'VIEW',
                'Users',
                User::FIELD_EMAIL,
            ],
            'Valid Change Field' => [
                'Change field "Email" on a User',
                'CHANGE',
                'Users',
                User::FIELD_EMAIL,
            ],
            'Valid View 2Part Field' => [
                'View field "Template Capabilities" on a Role Template',
                'VIEW',
                'RoleTemplates',
                RoleTemplate::FIELD_TEMPLATE_CAPABILITIES,
            ],
            'Valid Change 2Part Field' => [
                'Change field "Clean Domain" on a Scout Group',
                'CHANGE',
                'ScoutGroups',
                ScoutGroup::FIELD_CLEAN_DOMAIN,
            ],
            'Invalid Action Field' => [
                false,
                'GOAT', // Invalid
                'Users',
                User::FIELD_EMAIL,
            ],
            'Wrong Action Field' => [
                false,
                'UPDATE', // Entity Action
                'Users',
                User::FIELD_EMAIL,
            ],
            'Valid View Entity' => [
                'View a Role Template',
                'VIEW',
                'RoleTemplates',
            ],
            'Valid Change Entity' => [
                'Update a Scout Group',
                'UPDATE',
                'ScoutGroups',
            ],
            'Invalid Action Entity' => [
                false,
                'GOAT', // Invalid
                'Users',
            ],
            'Wrong Action Entity' => [
                false,
                'CHANGE', // Field Action
                'Users',
            ],
        ];
    }

    /**
     * @param string $expected Outcome expected
     * @param string $action The name of the Action performed
     * @param string $model The Model generated
     * @param string|null $field The Field being limited
     * @dataProvider providerCapabilityNameFormat
     * @return string
     */
    public static function testCapabilityNameFormat($expected, $action, $model, $field = null)
    {
        TestCase::assertEquals($expected, CapBuilder::capabilityNameFormat($action, $model, $field));
    }

    /**
     * @return array
     */
    public function providerCalculateLevel()
    {
        return [
            'Low Base, Low Multiplier ' => [
                2,
                1,
                1,
            ],
            'View Unrestricted, Negative Multiplier' => [
                1,
                4,
                -5,
            ],
            'View Restricted, Negative Multiplier' => [
                4,
                4,
                -5,
                true,
            ],
            'Over Max Base' => [
                5,
                10,
                1,
            ],
            'Under Max Base' => [
                1,
                -10,
                1,
            ],
            'Over Max Multiplier' => [
                5,
                10,
                1,
            ],
            'Under Max Multiplier' => [
                1,
                -10,
                1,
            ],
        ];
    }

    /**
     * @param int $expected Output level expected
     * @param int $baseLevel The Base Level for Capability
     * @param int $multiplier The Action Multiplier
     * @param bool|null $viewRestricted Is the view action restricted
     * @dataProvider providerCalculateLevel
     * @return void
     */
    public static function testCalculateLevel($expected, $baseLevel, $multiplier, $viewRestricted = false)
    {
        TestCase::assertEquals($expected, CapBuilder::calculateLevel($baseLevel, $multiplier, $viewRestricted));
    }

    /**
     * @return array
     */
    public function providerIsActionType()
    {
        return [
            'Is Action Type' => [
                'CREATE',
                true,
            ],
            'Is Not Action Type' => [
                'BLAH',
                false,
            ],
            'Is Empty' => [
                '',
                false,
            ],
        ];
    }

    /**
     * @param string $action The Action to be validated
     * @param bool $expected Outcome Expected
     * @dataProvider providerIsActionType
     * @return void
     */
    public static function testIsActionType($action, $expected)
    {
        TestCase::assertEquals($expected, CapBuilder::isActionType($action));
    }

    /**
     * @return array
     */
    public function providerIsFieldRestricted()
    {
        return [
            'Is Restricted' => [
                'Users',
                true,
            ],
            'Is Not Restricted' => [
                'Sections',
                false,
            ],
            'Not a Model' => [
                'FishTanks',
                false,
            ],
            'Is Empty' => [
                '',
                false,
            ],
        ];
    }

    /**
     * @param string $model The Model to be validated
     * @param bool $expected The Field Expected
     * @dataProvider providerIsFieldRestricted
     * @return void
     */
    public static function testIsFieldRestricted($model, $expected)
    {
        TestCase::assertEquals($expected, CapBuilder::isFieldRestricted($model));
    }

    /**
     * @return array
     */
    public function providerBreakCode()
    {
        return [
            'Is Action Type' => [
                'CREATE_ACTION',
                [],
            ],
            'Is Not Action Type' => [
                'BLAH_GOAT',
                [],
            ],
            'Not a Field' => [
                '',
                [],
            ],
            'Is Empty' => [
                '',
                [],
            ],
        ];
    }

    /**
     * @param string $capabilityCode The Capability Code to be broken
     * @param array $expected Outcome expected
     * @dataProvider providerBreakCode
     * @return void
     */
    public static function testBreakCode($capabilityCode, $expected)
    {
        TestCase::markTestIncomplete();
        TestCase::assertEquals($expected, CapBuilder::breakCode($capabilityCode));
    }

    /**
     * @return array
     */
    public function providerSpecialCode()
    {
        return [
            'Is Special Code' => [
                'DIRECTORY',
                true,
            ],
            'Is Not Special Code' => [
                'BLAH_GOAT',
                false,
            ],
            'Is Empty' => [
                '',
                false,
            ],
        ];
    }

    /**
     * @param string $capabilityCode Capability Code for testing
     * @param bool $expected Outcome expected
     * @dataProvider providerSpecialCode
     * @return void
     */
    public static function testIsSpecialCode($capabilityCode, $expected)
    {
        TestCase::assertEquals($expected, CapBuilder::isSpecialCode($capabilityCode));
    }
}
