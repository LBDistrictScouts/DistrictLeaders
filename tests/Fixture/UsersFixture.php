<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'username' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'membership_number' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'first_name' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'last_name' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'email' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'password' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'address_line_1' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'address_line_2' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'city' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'county' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'postcode' => ['type' => 'string', 'length' => 9, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'created' => ['type' => 'timestampfractional', 'length' => null, 'default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => null, 'precision' => 6],
        'modified' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'last_login' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'deleted' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'last_login_ip' => ['type' => 'string', 'length' => 255, 'default' => 'null', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'capabilities' => ['type' => 'json', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'user_state_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'cognito_enabled' => ['type' => 'boolean', 'length' => null, 'default' => 0, 'null' => false, 'comment' => null, 'precision' => null],
        'all_role_count' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'active_role_count' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'all_email_count' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'all_phone_count' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'receive_emails' => ['type' => 'boolean', 'length' => null, 'default' => 1, 'null' => false, 'comment' => null, 'precision' => null],
        'validated_email_count' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'validated_phone_count' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'activated' => ['type' => 'boolean', 'length' => null, 'default' => 0, 'null' => false, 'comment' => null, 'precision' => null],
        '_indexes' => [
            'users_password_state_id' => ['type' => 'index', 'columns' => ['user_state_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'users_username' => ['type' => 'unique', 'columns' => ['username'], 'length' => []],
            'users_membership_number' => ['type' => 'unique', 'columns' => ['membership_number'], 'length' => []],
            'users_email' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
            'users_password_state_id_fkey' => ['type' => 'foreign', 'columns' => ['user_state_id'], 'references' => ['user_states', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
        ],
    ];
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
            ],
        ];
        parent::init();
    }
}
