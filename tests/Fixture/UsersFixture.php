<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'username' => 'Lorem ipsum dolor sit amet',
                'membership_number' => 1,
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'email' => 'fish@4thgoat.org.uk',
                'password' => 'Lorem ipsum dolor sit amet',
                'address_line_1' => 'Lorem ipsum dolor sit amet',
                'address_line_2' => 'Lorem ipsum dolor sit amet',
                'city' => 'Lorem ipsum dolor sit amet',
                'county' => 'Lorem ipsum dolor sit amet',
                'postcode' => 'Lorem i',
                'capabilities' => null,
                'created' => 1565538411,
                'modified' => 1565538411,
                'last_login' => 1565538411,
                'last_login_ip' => '192.168.0.1',
                'deleted' => null,
                'user_state_id' => 1,
                'cognito_enabled' => false,
                'all_role_count' => 1,
                'active_role_count' => 1,
                'all_email_count' => 1,
                'all_phone_count' => 1,
                'receive_emails' => true,
                'validated_email_count' => 1,
                'validated_phone_count' => 1,
                'activated' => true,
                'search_string' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'tag_count' => 1,
            ],
            [
                'username' => 'FishyLlama',
                'membership_number' => 123,
                'first_name' => 'Llama',
                'last_name' => 'Fish',
                'email' => 'funky@4thgoat.org.uk',
                'password' => 'HeyGoNowGo',
                'address_line_1' => 'Bad Llama Road',
                'address_line_2' => 'Somewhere',
                'city' => 'NewPlace',
                'county' => 'OctopusLand',
                'postcode' => 'LN9 0II',
                'capabilities' => null,
                'created' => 1545696847,
                'modified' => 1545696847,
                'last_login' => null,
                'last_login_ip' => null,
                'deleted' => null,
                'user_state_id' => 1,
                'cognito_enabled' => false,
                'all_role_count' => 1,
                'active_role_count' => 1,
                'all_email_count' => 1,
                'all_phone_count' => 1,
                'receive_emails' => true,
                'validated_email_count' => 1,
                'validated_phone_count' => 1,
                'activated' => true,
                'search_string' => 'funky@4thgoat.org.uk Bad Llama Road',
                'tag_count' => 0,
            ],
        ];
        parent::init();
    }
}
