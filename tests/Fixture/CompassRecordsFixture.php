<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CompassRecordsFixture
 */
class CompassRecordsFixture extends TestFixture
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
                'document_version_id' => 1,
                'membership_number' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'forenames' => 'Joseph Gotlamb',
                'surname' => 'Jingles',
                'address' => 'Lorem ipsum dolor sit amet',
                'address_line1' => 'Lorem ipsum dolor sit amet',
                'address_line2' => 'Lorem ipsum dolor sit amet',
                'address_line3' => 'Lorem ipsum dolor sit amet',
                'address_town' => 'Lorem ipsum dolor sit amet',
                'address_county' => 'Lorem ipsum dolor sit amet',
                'postcode' => 'Lorem ipsum dolor sit amet',
                'address_country' => 'Lorem ipsum dolor sit amet',
                'role' => 'Lorem ipsum dolor sit amet',
                'location' => 'Lorem ipsum dolor sit amet',
                'phone' => 'Lorem ipsum dolor sit amet',
                'email' => 'octopus@monkey.goat',
                'preferred_forename' => 'Lorem ipsum dolor sit amet',
                'start_date' => 'Lorem ipsum dolor ',
                'role_status' => 'Lorem ipsum dolor ',
                'line_manager_number' => 1,
                'district' => 'Lorem ipsum dolor sit amet',
                'scout_group' => 'Lorem ipsum dolor sit amet',
                'scout_group_section' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
