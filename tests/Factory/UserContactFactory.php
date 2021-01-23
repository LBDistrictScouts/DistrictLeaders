<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * UserContactFactory
 */
class UserContactFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'UserContacts';
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
     * @return UserContactFactory
     */
    public function withUsers($parameter = null): UserContactFactory
    {
        return $this->with(
            'Users',
            \App\Test\Factory\UserFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return UserContactFactory
     */
    public function withUserContactTypes($parameter = null): UserContactFactory
    {
        return $this->with(
            'UserContactTypes',
            \App\Test\Factory\UserContactTypeFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return UserContactFactory
     */
    public function withDirectoryUsers($parameter = null): UserContactFactory
    {
        return $this->with(
            'DirectoryUsers',
            \App\Test\Factory\DirectoryUserFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return UserContactFactory
     */
    public function withAudits($parameter = null, int $n = 1): UserContactFactory
    {
        return $this->with(
            'Audits',
            \App\Test\Factory\AuditFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return UserContactFactory
     */
    public function withRoles($parameter = null, int $n = 1): UserContactFactory
    {
        return $this->with(
            'Roles',
            \App\Test\Factory\RoleFactory::make($parameter, $n)
        );
    }
}
