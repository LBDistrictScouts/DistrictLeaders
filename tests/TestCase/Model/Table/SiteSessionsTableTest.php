<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\SiteSession;
use App\Model\Table\SiteSessionsTable;
use Cake\I18n\Time;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SiteSessionsTable Test Case
 */
class SiteSessionsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var SiteSessionsTable
     */
    public SiteSessionsTable $SiteSessions;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SiteSessions') ? [] : ['className' => SiteSessionsTable::class];
        $this->SiteSessions = $this->getTableLocator()->get('SiteSessions', $config);

        $now = new Time('2018-12-26 23:22:30');
        Time::setTestNow($now);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SiteSessions);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    public function getGood()
    {
        return [
            'id' => 'saSOMSA' . random_int(1111111, 9999999) . 'asika' . random_int(111, 999),
            'data' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'expires' => 1,
        ];
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $actual = $this->SiteSessions->get(1)->toArray();

        $dates = [
            'modified',
            'created',
        ];

        foreach ($dates as $date) {
            $dateValue = $actual[$date];
            if (!is_null($dateValue)) {
                TestCase::assertInstanceOf('Cake\I18n\FrozenTime', $dateValue);
            }
            unset($actual[$date]);
        }

        $expected = [
            'id' => 1,
            'data' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'expires' => 1,
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->SiteSessions->find('all')->count();
        TestCase::assertEquals(1, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->SiteSessions->newEmptyEntity();
        $new->setAccess([
            'id',
            'data',
            'expires',
        ], true);
        $new = $this->SiteSessions->patchEntity($new, $good);
        TestCase::assertInstanceOf(SiteSession::class, $this->SiteSessions->save($new));
    }
}
