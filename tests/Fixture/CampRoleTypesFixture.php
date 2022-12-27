<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CampRoleTypesFixture
 */
class CampRoleTypesFixture extends TestFixture
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
                'created' => 1546807680,
                'modified' => 1546807680,
                'camp_role_type' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
