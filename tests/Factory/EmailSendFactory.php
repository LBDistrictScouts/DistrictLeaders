<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * EmailSendFactory
 */
class EmailSendFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'EmailSends';
    }

    /**
     * Defines the factory's default values. This is useful for
     * not nullable fields. You may use methods of the present factory here too.
     *
     * @return void
     */
    protected function setDefaultTemplate(): void
    {
        $this->setDefaultData(function (Generator $faker) {
            return [
                // set the model's default values
                // For example:
                // 'name' => $faker->lastName
            ];
        });
    }

    /**
     * @param array|callable|null|int $parameter
     * @return EmailSendFactory
     */
    public function withUsers($parameter = null): EmailSendFactory
    {
        return $this->with(
            'Users',
            \App\Test\Factory\UserFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return EmailSendFactory
     */
    public function withNotifications($parameter = null): EmailSendFactory
    {
        return $this->with(
            'Notifications',
            \App\Test\Factory\NotificationFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return EmailSendFactory
     */
    public function withEmailResponses($parameter = null, int $n = 1): EmailSendFactory
    {
        return $this->with(
            'EmailResponses',
            \App\Test\Factory\EmailResponseFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return EmailSendFactory
     */
    public function withTokens($parameter = null, int $n = 1): EmailSendFactory
    {
        return $this->with(
            'Tokens',
            \App\Test\Factory\TokenFactory::make($parameter, $n)
        );
    }
}
