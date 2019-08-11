<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotificationTypesTable;
use App\Utility\TextSafe;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\NotificationTypesTable Test Case
 */
class NotificationTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NotificationTypesTable
     */
    public $NotificationTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.NotificationTypes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('NotificationTypes') ? [] : ['className' => NotificationTypesTable::class];
        $this->NotificationTypes = TableRegistry::getTableLocator()->get('NotificationTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NotificationTypes);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     *
     * @throws
     */
    private function getGood()
    {
        $good = [
            'notification_type' => 'Notification ' . random_int(11111, 99999) . ' dolor ' . random_int(11111, 99999) . ' amet',
            'notification_description' => 'Balance Outstanding on Invoice',
            'icon' => 'fa-clock',
            'type_code' => TextSafe::shuffle(3) . '-' . TextSafe::shuffle(3),
        ];

        return $good;
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $actual = $this->NotificationTypes->get(1)->toArray();

        $expected = [
            'id' => 1,
            'notification_type' => 'Generic',
            'notification_description' => 'Generic Notification.',
            'icon' => 'fa-envelope',
            'type_code' => 'GEN-NOT',
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->NotificationTypes->find('all')->count();
        TestCase::assertEquals(7, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->NotificationTypes->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\NotificationType', $this->NotificationTypes->save($new));

        $required = [
            'notification_type',
            'icon',
            'notification_description',
            'type_code',
        ];

        foreach ($required as $require) {
            $reqArray = $good;
            unset($reqArray[$require]);
            $new = $this->NotificationTypes->newEntity($reqArray);
            TestCase::assertFalse($this->NotificationTypes->save($new));
        }

        $empties = [
        ];

        foreach ($empties as $empty) {
            $reqArray = $good;
            $reqArray[$empty] = '';
            $new = $this->NotificationTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\NotificationType', $this->NotificationTypes->save($new));
        }

        $notEmpties = [
            'notification_type',
            'icon',
            'notification_description',
            'type_code',
        ];

        foreach ($notEmpties as $notEmpty) {
            $reqArray = $good;
            $reqArray[$notEmpty] = '';
            $new = $this->NotificationTypes->newEntity($reqArray);
            TestCase::assertFalse($this->NotificationTypes->save($new));
        }

        $maxLengths = [
            'notification_description' => 255,
            'notification_type' => 45,
            'icon' => 45,
            'type_code' => 7,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $maxLength) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $maxLength);
            $new = $this->NotificationTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\NotificationType', $this->NotificationTypes->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $maxLength + 1);
            $new = $this->NotificationTypes->newEntity($reqArray);
            TestCase::assertFalse($this->NotificationTypes->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $values = $this->getGood();

        $existing = $this->NotificationTypes->get(1)->toArray();

        $values['notification_type'] = 'My new Camp Role Type';
        $new = $this->NotificationTypes->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\NotificationType', $this->NotificationTypes->save($new));

        $values['notification_type'] = $existing['notification_type'];
        $new = $this->NotificationTypes->newEntity($values);
        TestCase::assertFalse($this->NotificationTypes->save($new));

        $values = $this->getGood();

        $existing = $this->NotificationTypes->get(1)->toArray();

        $values['type_code'] = TextSafe::shuffle(3) . '-' . TextSafe::shuffle(3);
        $new = $this->NotificationTypes->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\NotificationType', $this->NotificationTypes->save($new));

        $values['type_code'] = $existing['type_code'];
        $new = $this->NotificationTypes->newEntity($values);
        TestCase::assertFalse($this->NotificationTypes->save($new));
    }

    /**
     * Test installBaseStatuses method
     *
     * @return void
     */
    public function testInstallBaseTypes()
    {
        $before = $this->NotificationTypes->find('all')->count();

        $installed = $this->NotificationTypes->installBaseTypes();

        TestCase::assertNotEquals($before, $installed);
        TestCase::assertNotEquals(0, $installed);

        $after = $this->NotificationTypes->find('all')->count();
        TestCase::assertTrue($after > $before);
    }

    /**
     * Test installBaseStatuses method
     *
     * @return void
     */
    public function testGetTypeCode()
    {
        // Known
        /** @var \App\Model\Entity\NotificationType $type */
        foreach ($this->NotificationTypes->find() as $type) {
            /** @var array $codes */
            $codes = explode('-', $type->type_code);
            $actual = $this->NotificationTypes->getTypeCode($codes[0], $codes[1]);
            TestCase::assertEquals($type->id, $actual);
        }

        // Generic
        $code = 'GEN';
        $subCode = 'NOT';
        $expected = $this->NotificationTypes->getTypeCode($code, $subCode);

        $code = 'NOT';
        $subCode = TextSafe::shuffle(3);
        $actual = $this->NotificationTypes->getTypeCode($code, $subCode);
        TestCase::assertEquals($expected, $actual);
    }
}
