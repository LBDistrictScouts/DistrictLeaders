<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserStatesFixture
 */
class UserStatesFixture extends TestFixture
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
                'user_state' => 'Active Directory User',
                'active' => true,
                'expired' => false,
                'precedence_order' => 1,
                'signature' => 63,
            ],
            [
                'user_state' => 'Provisional User',
                'active' => false,
                'expired' => false,
                'precedence_order' => 3,
                'signature' => 15,
            ],
            [
                'user_state' => 'Prevalidation',
                'active' => false,
                'expired' => false,
                'precedence_order' => 4,
                'signature' => 25,
            ],
            [
                'user_state' => 'Invited User',
                'active' => false,
                'expired' => false,
                'precedence_order' => 5,
                'signature' => 16,
            ],
            [
                'user_state' => 'Inactive User',
                'active' => false,
                'expired' => false,
                'precedence_order' => 6,
                'signature' => 43,
            ],
            [
                'user_state' => 'Monkey User',
                'active' => false,
                'expired' => false,
                'precedence_order' => 8,
                'signature' => 0,
            ],
        ];
        parent::init();
    }
}
