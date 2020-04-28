<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserContactTypesFixture
 */
class UserContactTypesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'user_contact_type' => ['type' => 'string', 'length' => 32, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => 'now()', 'null' => false, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
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
                'user_contact_type' => 'Email',
                'created' => 1564337519,
                'modified' => 1564337519,
            ],
        ];
        parent::init();
    }
}
