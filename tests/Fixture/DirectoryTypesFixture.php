<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DirectoryTypesFixture
 */
class DirectoryTypesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'directory_type' => ['type' => 'string', 'length' => 64, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'directory_type_code' => ['type' => 'string', 'length' => 64, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'directory_types_directory_type' => ['type' => 'unique', 'columns' => ['directory_type'], 'length' => []],
            'directory_types_directory_type_code' => ['type' => 'unique', 'columns' => ['directory_type_code'], 'length' => []],
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
                'directory_type' => 'Google G Suite',
                'directory_type_code' => 'GOOGLE',
            ],
        ];
        parent::init();
    }
}
