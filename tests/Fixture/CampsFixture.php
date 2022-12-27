<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CampsFixture
 */
class CampsFixture extends TestFixture
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
                'created' => 1546807673,
                'modified' => 1546807673,
                'deleted' => null,
                'camp_name' => 'Lorem ipsum dolor sit amet',
                'camp_type_id' => 1,
                'camp_start' => 1546807673,
                'camp_end' => 1546807673,
            ],
            [
                'created' => 1546807673,
                'modified' => 1546807673,
                'deleted' => null,
                'camp_name' => 'Lorem amet',
                'camp_type_id' => 1,
                'camp_start' => 1546807673,
                'camp_end' => 1546807673,
            ],
        ];
        parent::init();
    }
}
