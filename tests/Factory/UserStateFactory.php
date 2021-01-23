<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Factory;
use Faker\Generator;

/**
 * UserStateFactory
 */
class UserStateFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'UserStates';
    }

    /**
     * Defines the factory's default values. This is useful for
     * not nullable fields. You may use methods of the present factory here too.
     *
     * @return void
     */
    protected function setDefaultTemplate(): void
    {
        $this->setDefaultData(function (): array {
            return self::getGood();
        });
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $quantity
     * @return UserStateFactory
     */
    public function withUsers($parameter = null, int $quantity = 1): UserStateFactory
    {
        return $this->with(
            'Users',
            \App\Test\Factory\UserFactory::make($parameter, $quantity)
        );
    }

    /**
     * Generate a valid new Entity
     *
     * @return array
     */
    public static function getGood(): array
    {
        $faker = Factory::create('en_GB');

        return [
            'user_state' => ucwords($faker->words(2, true)),
            'active' => true,
            'expired' => false,
        ];
    }
}
