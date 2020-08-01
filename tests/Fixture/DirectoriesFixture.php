<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DirectoriesFixture
 */
class DirectoriesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'directory' => ['type' => 'string', 'length' => 64, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'directory_type_id' => ['type' => 'integer', 'length' => 10, 'default' => '1', 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'default' => 1, 'null' => false, 'comment' => null, 'precision' => null],
        'customer_reference' => ['type' => 'string', 'length' => 12, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'authorisation_token' => ['type' => 'json', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'directories_directory' => ['type' => 'unique', 'columns' => ['directory'], 'length' => []],
            'directories_customer_reference' => ['type' => 'unique', 'columns' => ['customer_reference'], 'length' => []],
            'directories_directory_type_id_fkey' => ['type' => 'foreign', 'columns' => ['directory_type_id'], 'references' => ['directory_types', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'directory' => 'Lorem ipsum dolor sit amet',
                'directory_type_id' => 1,
                'active' => 1,
                'customer_reference' => 'Lorem ipsu',
                'authorisation_token' => '',
            ],
        ];
        parent::init();
    }
}
