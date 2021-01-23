<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * DocumentVersionFactory
 */
class DocumentVersionFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'DocumentVersions';
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
     * @return DocumentVersionFactory
     */
    public function withDocuments($parameter = null): DocumentVersionFactory
    {
        return $this->with(
            'Documents',
            \App\Test\Factory\DocumentFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return DocumentVersionFactory
     */
    public function withDocumentEditions($parameter = null, int $n = 1): DocumentVersionFactory
    {
        return $this->with(
            'DocumentEditions',
            \App\Test\Factory\DocumentEditionFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return DocumentVersionFactory
     */
    public function withCompassRecords($parameter = null, int $n = 1): DocumentVersionFactory
    {
        return $this->with(
            'CompassRecords',
            \App\Test\Factory\CompassRecordFactory::make($parameter, $n)
        );
    }
}
