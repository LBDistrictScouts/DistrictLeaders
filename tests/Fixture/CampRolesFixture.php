<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CampRolesFixture
 */
class CampRolesFixture extends TestFixture
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
                'created' => 1546807693,
                'modified' => 1546807693,
                'camp_id' => 1,
                'user_id' => 1,
                'camp_role_type_id' => 1,
            ],
        ];
        parent::init();
    }
}
