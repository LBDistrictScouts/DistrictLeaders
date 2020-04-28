<?php
namespace App\Test\Fixture;

use Cake\ElasticSearch\TestSuite\TestFixture;

/**
 * Articles fixture
 */
class ContactsFixture extends TestFixture
{
    /**
     * The table/type for this fixture.
     *
     * @var string
     */
    public $table = 'contacts';

    /**
     * The mapping data.
     *
     * @var array
     */
    public $schema = [
        'id' => ['type' => 'integer'],
        'email' => [
            'type' => 'nested',
            'properties' => [
                'email' => ['type' => 'string'],
            ],
        ],
        'first_name' => ['type' => 'string'],
        'last_name' => ['type' => 'string'],
        'full_name' => ['type' => 'string'],
        'membership_number' => ['type' => 'integer'],
    ];

    public $records = [
        [
            'id' => 1,
            'email' => [
                [
                    'email' => 'jacob@llama.com',
                ],
                [
                    'email' => 'fish@jacob.com',
                ],
            ],
            'first_name' => 'Jacob',
            'last_name' => 'Tyler',
            'full_name' => 'Jacob Tyler',
            'membership_number' => 999282,
        ],
    ];
}
