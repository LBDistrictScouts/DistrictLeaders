<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserContactsFixture
 */
class UserContactsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'contact_field' => ['type' => 'string', 'length' => 64, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'user_contact_type_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestampfractional', 'length' => null, 'default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => null, 'precision' => 6],
        'modified' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'verified' => ['type' => 'boolean', 'length' => null, 'default' => 0, 'null' => false, 'comment' => null, 'precision' => null],
        'deleted' => ['type' => 'timestampfractional', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 6],
        'directory_user_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'user_contacts_directory_user_id_fkey' => ['type' => 'foreign', 'columns' => ['directory_user_id'], 'references' => ['directory_users', 'id'], 'update' => 'noAction', 'delete' => 'setNull', 'length' => []],
            'user_contacts_user_contact_type_id_fkey' => ['type' => 'foreign', 'columns' => ['user_contact_type_id'], 'references' => ['user_contacts', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'user_contacts_user_id_fkey' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'contact_field' => 'james@peach.com',
                'user_id' => 1,
                'user_contact_type_id' => 1,
                'created' => 1564337533,
                'modified' => 1564337533,
                'verified' => 1,
                'deleted' => null,
                'directory_user_id' => 1,
            ],
            [
                'contact_field' => 'james@goat.com',
                'user_id' => 1,
                'user_contact_type_id' => 1,
                'created' => 1564337533,
                'modified' => 1564337533,
                'verified' => false,
                'deleted' => null,
                'directory_user_id' => 1,
            ],
        ];
        parent::init();
    }
}
