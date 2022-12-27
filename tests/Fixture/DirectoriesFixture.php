<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use App\Model\Entity\Directory;
use Cake\TestSuite\Fixture\TestFixture;

/**
 * DirectoriesFixture
 */
class DirectoriesFixture extends TestFixture
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
                Directory::FIELD_DIRECTORY => 'Lorem ipsum dolor sit amet',
                Directory::FIELD_DIRECTORY_TYPE_ID => 1,
                Directory::FIELD_ACTIVE => 1,
                Directory::FIELD_CUSTOMER_REFERENCE => 'Lorem ipsu',
                Directory::FIELD_AUTHORISATION_TOKEN => '',
            ],
        ];
        parent::init();
    }
}
