<?php
namespace App\Test\Fixture;

use App\Model\Entity\Capability;
use Cake\TestSuite\Fixture\TestFixture;

/**
 * CapabilitiesFixture
 */
class CapabilitiesFixture extends TestFixture
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
                Capability::FIELD_CAPABILITY_CODE => 'ALL',
                Capability::FIELD_CAPABILITY => 'SuperUser Permissions',
                Capability::FIELD_MIN_LEVEL => 5, // Config Level
            ],
            [
                Capability::FIELD_CAPABILITY_CODE => 'EDIT_GROUP',
                Capability::FIELD_CAPABILITY => 'Edit Group',
                Capability::FIELD_MIN_LEVEL => 4, // District Level
            ],
            [
                Capability::FIELD_CAPABILITY_CODE => 'EDIT_SECT',
                Capability::FIELD_CAPABILITY => 'Edit Section',
                Capability::FIELD_MIN_LEVEL => 3, // Group Level
            ],
            [
                Capability::FIELD_CAPABILITY_CODE => 'EDIT_USER',
                Capability::FIELD_CAPABILITY => 'Edit User',
                Capability::FIELD_MIN_LEVEL => 2, // Section Level
            ],
            [
                Capability::FIELD_CAPABILITY_CODE => 'OWN_USER',
                Capability::FIELD_CAPABILITY => 'Edit Own User',
                Capability::FIELD_MIN_LEVEL => 1, // User Level
            ],
            [
                Capability::FIELD_CAPABILITY_CODE => 'LOGIN',
                Capability::FIELD_CAPABILITY => 'Login',
                Capability::FIELD_MIN_LEVEL => 0, // Base Level
            ],
        ];
        parent::init();
    }
}
