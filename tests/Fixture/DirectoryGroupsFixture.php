<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use App\Model\Entity\DirectoryGroup;
use Cake\TestSuite\Fixture\TestFixture;

/**
 * DirectoryGroupsFixture
 */
class DirectoryGroupsFixture extends TestFixture
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
                DirectoryGroup::FIELD_DIRECTORY_ID => 1,
                DirectoryGroup::FIELD_DIRECTORY_GROUP_NAME => 'Lorem ipsum dolor sit amet',
                DirectoryGroup::FIELD_DIRECTORY_GROUP_EMAIL => 'Lorem ipsum dolor sit amet',
                DirectoryGroup::FIELD_DIRECTORY_GROUP_REFERENCE => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
