<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
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
        'username' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'membership_number' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'first_name' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'last_name' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'address_line_1' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'address_line_2' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'city' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'county' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'postcode' => ['type' => 'string', 'length' => 9, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'last_login' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'deleted' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'last_login_ip' => ['type' => 'string', 'length' => 255, 'default' => 'null', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'capabilities' => ['type' => 'json', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'password_state_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_indexes' => [
            'users_password_state_id' => ['type' => 'index', 'columns' => ['password_state_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'users_username' => ['type' => 'unique', 'columns' => ['username'], 'length' => []],
            'users_membership_number' => ['type' => 'unique', 'columns' => ['membership_number'], 'length' => []],
            'users_email' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
            'users_password_state_id_fkey' => ['type' => 'foreign', 'columns' => ['password_state_id'], 'references' => ['password_states', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
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
                'password_state_id' => 1,
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
                'password_state_id' => 1,
            ],
        ];
        parent::init();
    }
}
