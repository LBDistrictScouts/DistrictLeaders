<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserStatesFixture
 */
class UserStatesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'user_state' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'default' => 1, 'null' => false, 'comment' => null, 'precision' => null],
        'expired' => ['type' => 'boolean', 'length' => null, 'default' => 1, 'null' => false, 'comment' => null, 'precision' => null],
        'precedence_order' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'signature' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'user_states_order' => ['type' => 'unique', 'columns' => ['precedence_order'], 'length' => []],
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
                'user_state' => 'Active Directory User',
                'active' => true,
                'expired' => false,
                'precedence_order' => 1,
                'signature' => 63,
            ],
            [
                'user_state' => 'Provisional User',
                'active' => false,
                'expired' => false,
                'precedence_order' => 3,
                'signature' => 15,
            ],
            [
                'user_state' => 'Prevalidation',
                'active' => false,
                'expired' => false,
                'precedence_order' => 4,
                'signature' => 25,
            ],
            [
                'user_state' => 'Invited User',
                'active' => false,
                'expired' => false,
                'precedence_order' => 5,
                'signature' => 16,
            ],
            [
                'user_state' => 'Inactive User',
                'active' => false,
                'expired' => false,
                'precedence_order' => 6,
                'signature' => 43,
            ],
            [
                'user_state' => 'Monkey User',
                'active' => false,
                'expired' => false,
                'precedence_order' => 8,
                'signature' => 0,
            ],
        ];
        parent::init();
    }
}
