<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * EmailResponseFactory
 */
class EmailResponseFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'EmailResponses';
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
     * @return EmailResponseFactory
     */
    public function withEmailSends($parameter = null): EmailResponseFactory
    {
        return $this->with(
            'EmailSends',
            \App\Test\Factory\EmailSendFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return EmailResponseFactory
     */
    public function withEmailResponseTypes($parameter = null): EmailResponseFactory
    {
        return $this->with(
            'EmailResponseTypes',
            \App\Test\Factory\EmailResponseTypeFactory::make($parameter)
        );
    }
}
