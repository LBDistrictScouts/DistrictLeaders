<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserContactsFixture
 */
class UserContactsFixture extends TestFixture
{
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
