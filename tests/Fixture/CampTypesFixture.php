<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CampTypesFixture
 */
class CampTypesFixture extends TestFixture
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
                'camp_type' => 'Lorem ipsum sit amet',
            ],
        ];
        parent::init();
    }
}
