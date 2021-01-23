<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * DirectoryFactory
 */
class DirectoryFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Directories';
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
     * @return DirectoryFactory
     */
    public function withDirectoryTypes($parameter = null): DirectoryFactory
    {
        return $this->with(
            'DirectoryTypes',
            \App\Test\Factory\DirectoryTypeFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return DirectoryFactory
     */
    public function withDirectoryDomains($parameter = null, int $n = 1): DirectoryFactory
    {
        return $this->with(
            'DirectoryDomains',
            \App\Test\Factory\DirectoryDomainFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return DirectoryFactory
     */
    public function withDirectoryGroups($parameter = null, int $n = 1): DirectoryFactory
    {
        return $this->with(
            'DirectoryGroups',
            \App\Test\Factory\DirectoryGroupFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return DirectoryFactory
     */
    public function withDirectoryUsers($parameter = null, int $n = 1): DirectoryFactory
    {
        return $this->with(
            'DirectoryUsers',
            \App\Test\Factory\DirectoryUserFactory::make($parameter, $n)
        );
    }
}
