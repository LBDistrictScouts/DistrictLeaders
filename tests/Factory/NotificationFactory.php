<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * NotificationFactory
 */
class NotificationFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Notifications';
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
     * @return NotificationFactory
     */
    public function withUsers($parameter = null): NotificationFactory
    {
        return $this->with(
            'Users',
            \App\Test\Factory\UserFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return NotificationFactory
     */
    public function withNotificationTypes($parameter = null): NotificationFactory
    {
        return $this->with(
            'NotificationTypes',
            \App\Test\Factory\NotificationTypeFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return NotificationFactory
     */
    public function withEmailSends($parameter = null, int $n = 1): NotificationFactory
    {
        return $this->with(
            'EmailSends',
            \App\Test\Factory\EmailSendFactory::make($parameter, $n)
        );
    }
}
