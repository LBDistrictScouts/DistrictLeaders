<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmailResponsesFixture
 */
class EmailResponsesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'email_send_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'deleted' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'email_response_type_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'received' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'link_clicked' => ['type' => 'string', 'length' => 511, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'ip_address' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'bounce_reason' => ['type' => 'string', 'length' => 511, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'message_size' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_indexes' => [
            'email_responses_email_send_id' => ['type' => 'index', 'columns' => ['email_send_id'], 'length' => []],
            'email_responses_email_response_type_id' => ['type' => 'index', 'columns' => ['email_response_type_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'email_responses_email_response_type_id_fkey' => ['type' => 'foreign', 'columns' => ['email_response_type_id'], 'references' => ['email_response_types', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'email_responses_email_send_id_fkey' => ['type' => 'foreign', 'columns' => ['email_send_id'], 'references' => ['email_sends', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
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
                'email_send_id' => 1,
                'email_response_type_id' => 1,
                'created' => 1554028717,
                'received' => 1554028717,
                'link_clicked' => 'Lorem ipsum dolor sit amet',
                'ip_address' => 'Lorem ipsum dolor sit amet',
                'bounce_reason' => 'Lorem ipsum dolor sit amet',
                'message_size' => 1,
                'deleted' => null,
            ],
        ];
        parent::init();
    }
}
