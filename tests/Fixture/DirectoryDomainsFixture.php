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
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'directory_domain' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'directory_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'ingest' => ['type' => 'boolean', 'length' => null, 'default' => 1, 'null' => false, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'directory_domains_directory_domain' => ['type' => 'unique', 'columns' => ['directory_domain'], 'length' => []],
            'directory_domains_directory_id_fkey' => ['type' => 'foreign', 'columns' => ['directory_id'], 'references' => ['directories', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
    ];
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
