<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmailSendsFixture
 */
class EmailSendsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'email_generation_code' => ['type' => 'string', 'length' => 30, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'email_template' => ['type' => 'string', 'length' => 30, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'include_token' => ['type' => 'boolean', 'length' => null, 'default' => 0, 'null' => false, 'comment' => null, 'precision' => null],
        'created' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'modified' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'deleted' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'sent' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'message_send_code' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'subject' => ['type' => 'string', 'length' => 511, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'routing_domain' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'from_address' => ['type' => 'string', 'length' => 511, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'friendly_from' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'notification_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_indexes' => [
            'email_sends_message_send_code' => ['type' => 'index', 'columns' => ['message_send_code'], 'length' => []],
            'email_sends_user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'email_sends_notification_id' => ['type' => 'index', 'columns' => ['notification_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'email_sends_notification_id_fkey' => ['type' => 'foreign', 'columns' => ['notification_id'], 'references' => ['notifications', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'email_sends_user_id_fkey' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
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
                'email_generation_code' => 'RSV-2-5DR',
                'email_template' => 'reservation',
                'include_token' => 1,
                'created' => 1558196079,
                'modified' => 1558196079,
                'sent' => 1558196079,
                'message_send_code' => 'PSJs821sxa928as219SMZX9',
                'user_id' => 1,
                'subject' => 'Lorem ipsum dolor sit amet',
                'routing_domain' => 'Lorem ipsum dolor sit amet',
                'from_address' => 'Lorem ipsum dolor sit amet',
                'friendly_from' => 'Lorem ipsum dolor sit amet',
                'notification_id' => 1,
                'deleted' => null,
            ],
            [
                'email_generation_code' => 'RSV-1-5DR',
                'email_template' => 'reservation',
                'include_token' => 1,
                'created' => 1558196079,
                'modified' => 1558196079,
                'sent' => 1558196079,
                'message_send_code' => 'PSJs821sxa928as219SMZX9',
                'user_id' => 1,
                'subject' => 'Lorem ipsum dolor sit amet',
                'routing_domain' => 'Lorem ipsum dolor sit amet',
                'from_address' => 'Lorem ipsum dolor sit amet',
                'friendly_from' => 'Lorem ipsum dolor sit amet',
                'notification_id' => 1,
                'deleted' => null,
            ],
        ];
        parent::init();
    }
}
