<?php
namespace App\Test\Fixture;

use Cake\ElasticSearch\TestSuite\TestFixture;

/**
 * Articles fixture
 */
class EmailsFixture extends TestFixture
{
    /**
     * The table/type for this fixture.
     *
     * @var string
     */
    public $table = 'emails';

    /**
     * The mapping data.
     *
     * @var array
     */
    public $schema = [
        'id' => ['type' => 'integer'],
        'email' => ['type' => 'string'],
    ];

    public $records = [
        [
            'id' => 1,
            'email' => 'jacob@llama.com',
        ],
        [
            'id' => 2,
            'email' => 'fish@jacob.com',
        ],
    ];
}
