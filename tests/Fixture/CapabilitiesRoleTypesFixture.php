<?php
namespace App\Test\Fixture;

use App\Model\Entity\CapabilitiesRoleType;
use Cake\TestSuite\Fixture\TestFixture;

/**
 * CapabilitiesRoleTypesFixture
 */
class CapabilitiesRoleTypesFixture extends TestFixture
{
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                CapabilitiesRoleType::FIELD_CAPABILITY_ID => 1, // Level 5
                CapabilitiesRoleType::FIELD_ROLE_TYPE_ID => 5,
                CapabilitiesRoleType::FIELD_TEMPLATE => false,
            ],
            [
                CapabilitiesRoleType::FIELD_CAPABILITY_ID => 2, // Level 4
                CapabilitiesRoleType::FIELD_ROLE_TYPE_ID => 4,
                CapabilitiesRoleType::FIELD_TEMPLATE => false,
            ],
            [
                CapabilitiesRoleType::FIELD_CAPABILITY_ID => 3, // Level 3
                CapabilitiesRoleType::FIELD_ROLE_TYPE_ID => 3,
                CapabilitiesRoleType::FIELD_TEMPLATE => false,
            ],
            [
                CapabilitiesRoleType::FIELD_CAPABILITY_ID => 4, // Level 2
                CapabilitiesRoleType::FIELD_ROLE_TYPE_ID => 2,
                CapabilitiesRoleType::FIELD_TEMPLATE => false,
            ],
            [
                CapabilitiesRoleType::FIELD_CAPABILITY_ID => 5, // Level 1
                CapabilitiesRoleType::FIELD_ROLE_TYPE_ID => 1,
                CapabilitiesRoleType::FIELD_TEMPLATE => false,
            ],
            [
                CapabilitiesRoleType::FIELD_CAPABILITY_ID => 6, // Level 0
                CapabilitiesRoleType::FIELD_ROLE_TYPE_ID => 5,
                CapabilitiesRoleType::FIELD_TEMPLATE => false,
            ],
            [
                CapabilitiesRoleType::FIELD_CAPABILITY_ID => 6, // Level 0
                CapabilitiesRoleType::FIELD_ROLE_TYPE_ID => 4,
                CapabilitiesRoleType::FIELD_TEMPLATE => false,
            ],
            [
                CapabilitiesRoleType::FIELD_CAPABILITY_ID => 6, // Level 0
                CapabilitiesRoleType::FIELD_ROLE_TYPE_ID => 3,
                CapabilitiesRoleType::FIELD_TEMPLATE => false,
            ],
            [
                CapabilitiesRoleType::FIELD_CAPABILITY_ID => 6, // Level 0
                CapabilitiesRoleType::FIELD_ROLE_TYPE_ID => 2,
                CapabilitiesRoleType::FIELD_TEMPLATE => false,
            ],
            [
                CapabilitiesRoleType::FIELD_CAPABILITY_ID => 6, // Level 0
                CapabilitiesRoleType::FIELD_ROLE_TYPE_ID => 1,
                CapabilitiesRoleType::FIELD_TEMPLATE => false,
            ],
        ];
        parent::init();
    }
}
