<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NotificationTypesFixture
 */
class NotificationTypesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'notification_type' => ['type' => 'string', 'length' => 45, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'notification_description' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'icon' => ['type' => 'string', 'length' => 45, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'type_code' => ['type' => 'string', 'length' => 7, 'default' => 'ABC-DEF', 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'content_template' => ['type' => 'string', 'length' => 32, 'default' => 'standard', 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
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
                'notification_type' => 'Generic',
                'notification_description' => 'Generic Notification.',
                'icon' => 'fa-envelope',
                'type_code' => 'GEN-NOT',
                'content_template' => 'standard',
            ],
            [
                'notification_type' => 'Welcome',
                'notification_description' => 'Welcome to the System Email & Notification.',
                'icon' => 'fa-user',
                'type_code' => 'USR-NEW',
                'content_template' => 'welcome',
            ],
            [
                'notification_type' => 'Password Reset',
                'notification_description' => 'A password reset password has been triggered.',
                'icon' => 'fa-unlock',
                'type_code' => 'USR-PWD',
                'content_template' => 'password',
            ],
            [
                'notification_type' => 'New Payment Received',
                'notification_description' => 'Notification that a payment has been recorded by an administrator.',
                'icon' => 'fa-receipt',
                'type_code' => 'INV-PAY',
                'content_template' => 'payment',
            ],
            [
                'notification_type' => 'Surcharge Added',
                'notification_description' => 'A Payment Surcharge was added to the Invoice.',
                'icon' => 'fa-tag',
                'type_code' => 'INV-SUR',
                'content_template' => 'charge',
            ],
            [
                'notification_type' => 'Outstanding Balance',
                'notification_description' => 'Balance Outstanding on Invoice',
                'icon' => 'fa-clock',
                'type_code' => 'INV-OUT',
                'content_template' => 'outstanding',
            ],
            [
                'notification_type' => 'Deposit Outstanding',
                'notification_description' => 'Notification of an Invoice where the deposit is past due.',
                'icon' => 'fa-clock',
                'type_code' => 'INV-DEP',
                'content_template' => 'deposit',
            ],
        ];
        parent::init();
    }
}
