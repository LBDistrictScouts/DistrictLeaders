<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserContactTypesFixture
 */
class UserContactTypesFixture extends TestFixture
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
                'user_contact_type' => 'Email',
                'created' => 1564337519,
                'modified' => 1564337519,
            ],
            [
                'user_contact_type' => 'Phone',
                'created' => 1564337519,
                'modified' => 1564337519,
            ],
        ];
        parent::init();
    }
}
