<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\CsvBehavior;
use Cake\TestSuite\TestCase;

/**
 * CakePHP-CSV\Model\Behavior\CsvBehavior Test Case
 */
class CsvBehaviorTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserStates',
        'app.Users',
        'app.CapabilitiesRoleTypes',
        'app.Capabilities',
        'app.ScoutGroups',
        'app.SectionTypes',
        'app.RoleTemplates',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.Audits',
        'app.UserContactTypes',
        'app.UserContacts',
        'app.Roles',
        'app.CampTypes',
        'app.Camps',
        'app.CampRoleTypes',
        'app.CampRoles',
        'app.NotificationTypes',
        'app.Notifications',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',

        'app.DirectoryTypes',
        'app.Directories',
        'app.DirectoryDomains',
        'app.DirectoryUsers',
        'app.DirectoryGroups',
        'app.RoleTypesDirectoryGroups',
    ];

    /**
     * @var \App\Model\Behavior\CsvBehavior
     */
    protected $Csv;

    /**
     * @var \Cake\ORM\Table
     */
    protected $CompassRecords;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->CompassRecords = $this->getTableLocator()->get('CompassRecords');
        $this->Csv = new CsvBehavior(
            $this->CompassRecords,
            [
                'text' => true,
            ]
        );
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Csv);

        parent::tearDown();
    }

    /**
     * @return string
     */
    private function getImportData(): string
    {
        $csv = 'title, body, created, user_id, comments.0.body, comments.1.body' . PHP_EOL;
        $csv .= 'A title once again,And the article body follows,2014-05-04 10:30:32, 3,First comment,Second comment' . PHP_EOL;
        $csv .= 'The title,This is the article body.,2014-05-04 10:30:33, 5,Third comment,Another comment' . PHP_EOL;
        $csv .= 'Title strikes back,This is really exciting! Not.,2014-05-05 10:30:39, 3,Awesome comment,Last comment' . PHP_EOL;

        return $csv;
    }

    /**
     * Test importCsv method
     *
     * @return void
     */
    public function testImportCsv()
    {
        $csv = $this->getImportData();

        $expected = [
            0 => [
                'title' => 'A title once again',
                'body' => 'And the article body follows',
                'created' => '2014-05-04 10:30:32',
                'user_id' => 3,
                'comments' => [
                    ['body' => 'First comment'],
                    ['body' => 'Second comment'],
                ],
            ],
            1 => [
                'title' => 'The title',
                'body' => 'This is the article body.',
                'created' => '2014-05-04 10:30:33',
                'user_id' => 5,
                'comments' => [
                    ['body' => 'Third comment'],
                    ['body' => 'Another comment'],
                ],
            ],
            2 => [
                'title' => 'Title strikes back',
                'body' => 'This is really exciting! Not.',
                'created' => '2014-05-05 10:30:39',
                'user_id' => 3,
                'comments' => [
                    ['body' => 'Awesome comment'],
                    ['body' => 'Last comment'],
                ],
            ],
        ];
        $actual = $this->Csv->importCsv($csv);
        static::assertEquals($expected, $actual);

        $expected = [
            0 => [
                'title' => 'A title once again',
                'body' => 'And the article body follows',
            ],
            1 => [
                'title' => 'The title',
                'body' => 'This is the article body.',
            ],
            2 => [
                'title' => 'Title strikes back',
                'body' => 'This is really exciting! Not.',
            ],
        ];
        $actual = $this->Csv->importCsv(
            $csv,
            ['title','body']
        );
        static::assertEquals($expected, $actual);
    }
}
