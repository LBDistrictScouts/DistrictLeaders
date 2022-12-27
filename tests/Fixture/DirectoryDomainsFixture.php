<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use App\Model\Entity\DirectoryDomain;
use Cake\TestSuite\Fixture\TestFixture;

/**
 * DirectoryDomainsFixture
 */
class DirectoryDomainsFixture extends TestFixture
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
                DirectoryDomain::FIELD_DIRECTORY_DOMAIN => 'goatface.org.uk',
                DirectoryDomain::FIELD_DIRECTORY_ID => 1,
                DirectoryDomain::FIELD_INGEST => true,
            ],
        ];
        parent::init();
    }
}
