<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TokensFixture
 */
class TokensFixture extends TestFixture
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
                'token' => 'Password Reset Token for Jacob Tyler',
                'email_send_id' => 1,
                'created' => '2019-03-31 11:26:44',
                'modified' => '2019-03-31 11:26:44',
                'expires' => '2019-04-30 11:26:44',
                'utilised' => null,
                'active' => true,
                'deleted' => null,
                'hash' => 'de3fcc4b18f723440bda95f40ef791e9953b0c03044b3a736065759800861012',
                'random_number' => 54498,
                'token_header' => [
                    'authenticate' => false,
                    'redirect' => [
                        'controller' => 'Applications',
                        'action' => 'view',
                        'prefix' => false,
                        1,
                    ],
                ],
            ],
        ];
        parent::init();
    }
}
