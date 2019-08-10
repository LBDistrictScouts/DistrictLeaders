<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TokensFixture
 */
class TokensFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'token' => ['type' => 'string', 'length' => 511, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'expires' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'utilised' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'default' => 1, 'null' => false, 'comment' => null, 'precision' => null],
        'deleted' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'hash' => ['type' => 'string', 'length' => 511, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'random_number' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'token_header' => ['type' => 'json', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'email_send_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tokens_email_send_id' => ['type' => 'index', 'columns' => ['email_send_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tokens_email_send_id_fkey' => ['type' => 'foreign', 'columns' => ['email_send_id'], 'references' => ['email_sends', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
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
                'id' => 1,
                'token' => 'Lorem ipsum dolor sit amet',
                'created' => 1565473683,
                'modified' => 1565473683,
                'expires' => 1565473683,
                'utilised' => 1565473683,
                'active' => 1,
                'deleted' => 1565473683,
                'hash' => 'Lorem ipsum dolor sit amet',
                'random_number' => 1,
                'token_header' => '',
                'email_send_id' => 1
            ],
        ];
        parent::init();
    }
}
