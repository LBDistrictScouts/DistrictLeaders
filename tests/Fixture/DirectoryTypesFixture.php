<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use App\Model\Entity\DirectoryType;
use Cake\TestSuite\Fixture\TestFixture;

/**
 * DirectoryTypesFixture
 */
class DirectoryTypesFixture extends TestFixture
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
                DirectoryType::FIELD_DIRECTORY_TYPE => 'Google G Suite',
                DirectoryType::FIELD_DIRECTORY_TYPE_CODE => 'GOOGLE',
            ],
        ];
        parent::init();
    }
}
