<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NotificationsFixture
 */
class NotificationsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'user_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'notification_type_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'notification_header' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'created' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'read_date' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'notification_source' => ['type' => 'string', 'length' => 63, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'deleted' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'body_content' => ['type' => 'json', 'length' => null, 'default' => '{}', 'null' => false, 'comment' => null, 'precision' => null],
        'subject_link' => ['type' => 'json', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'new' => ['type' => 'boolean', 'length' => null, 'default' => 1, 'null' => false, 'comment' => null, 'precision' => null],
        'text' => ['type' => 'string', 'length' => 1, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'link_id' => ['type' => 'string', 'length' => 1, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'link_controller'  => ['type' => 'string', 'length' => 1, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'link_prefix'  => ['type' => 'string', 'length' => 1, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'link_action'  => ['type' => 'string', 'length' => 1, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        '_indexes' => [
            'notifications_user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'notifications_notification_type_id' => ['type' => 'index', 'columns' => ['notification_type_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
                'user_id' => 1,
                'notification_type_id' => 1,
                'notification_header' => 'A payment has been recorded.',
                'created' => '2018-02-25 15:56:43',
                'read_date' => '2018-02-25 15:58:04',
                'notification_source' => 'System Generated',
                'deleted' => null,
                'body_content' => [
                    'Chocolate',
                ],
                'subject_link' => null,
            ],
        ];
        parent::init();
    }
}
