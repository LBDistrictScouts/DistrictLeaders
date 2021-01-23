<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * UserFactory
 */
class UserFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Users';
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
     * @return UserFactory
     */
    public function withUserStates($parameter = null): UserFactory
    {
        return $this->with(
            'UserStates',
            \App\Test\Factory\UserStateFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return UserFactory
     */
    public function withChanges($parameter = null, int $n = 1): UserFactory
    {
        return $this->with(
            'Changes',
            \App\Test\Factory\AuditFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return UserFactory
     */
    public function withAudits($parameter = null, int $n = 1): UserFactory
    {
        return $this->with(
            'Audits',
            \App\Test\Factory\AuditFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return UserFactory
     */
    public function withCampRoles($parameter = null, int $n = 1): UserFactory
    {
        return $this->with(
            'CampRoles',
            \App\Test\Factory\CampRoleFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return UserFactory
     */
    public function withEmailSends($parameter = null, int $n = 1): UserFactory
    {
        return $this->with(
            'EmailSends',
            \App\Test\Factory\EmailSendFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return UserFactory
     */
    public function withNotifications($parameter = null, int $n = 1): UserFactory
    {
        return $this->with(
            'Notifications',
            \App\Test\Factory\NotificationFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return UserFactory
     */
    public function withRoles($parameter = null, int $n = 1): UserFactory
    {
        return $this->with(
            'Roles',
            \App\Test\Factory\RoleFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return UserFactory
     */
    public function withUserContacts($parameter = null, int $n = 1): UserFactory
    {
        return $this->with(
            'UserContacts',
            \App\Test\Factory\UserContactFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return UserFactory
     */
    public function withContactEmails($parameter = null, int $n = 1): UserFactory
    {
        return $this->with(
            'ContactEmails',
            \App\Test\Factory\UserContactFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return UserFactory
     */
    public function withContactNumbers($parameter = null, int $n = 1): UserFactory
    {
        return $this->with(
            'ContactNumbers',
            \App\Test\Factory\UserContactFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return UserFactory
     */
    public function withDirectoryUsers($parameter = null, int $n = 1): UserFactory
    {
        return $this->with(
            'DirectoryUsers',
            \App\Test\Factory\DirectoryUserFactory::make($parameter, $n)->without('Users')
        );
    }
}
