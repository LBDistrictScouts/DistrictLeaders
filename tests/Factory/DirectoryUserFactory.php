<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * DirectoryUserFactory
 */
class DirectoryUserFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'DirectoryUsers';
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
     * @return DirectoryUserFactory
     */
    public function withDirectories($parameter = null): DirectoryUserFactory
    {
        return $this->with(
            'Directories',
            \App\Test\Factory\DirectoryFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return DirectoryUserFactory
     */
    public function withUserContacts($parameter = null): DirectoryUserFactory
    {
        return $this->with(
            'UserContacts',
            \App\Test\Factory\UserContactFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return DirectoryUserFactory
     */
    public function withUsers($parameter = null, int $n = 1): DirectoryUserFactory
    {
        return $this->with(
            'Users',
            \App\Test\Factory\UserFactory::make($parameter, $n)->without('DirectoryUsers')
        );
    }
}
