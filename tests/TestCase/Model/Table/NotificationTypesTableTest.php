<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\NotificationType;
use App\Model\Table\NotificationTypesTable;
use App\Utility\TextSafe;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotificationTypesTable Test Case
 */
class NotificationTypesTableTest extends TestCase
{
    use ModelTestTrait;

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
        'app.NotificationTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('NotificationTypes') ? [] : ['className' => NotificationTypesTable::class];
        $this->NotificationTypes = $this->getTableLocator()->get('NotificationTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->NotificationTypes);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     * @throws
     */
    private function getGood()
    {
        return [
            NotificationType::FIELD_NOTIFICATION_TYPE => 'Notification ' . random_int(11111, 99999) . ' dolor ' . random_int(11111, 99999) . ' amet',
            NotificationType::FIELD_NOTIFICATION_DESCRIPTION => 'Balance Outstanding on Invoice',
            NotificationType::FIELD_ICON => 'fa-clock',
            NotificationType::FIELD_TYPE_CODE => TextSafe::shuffle(3) . '-' . TextSafe::shuffle(3),
        ];
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $expected = [
            NotificationType::FIELD_ID => 1,
            NotificationType::FIELD_NOTIFICATION_TYPE => 'Generic',
            NotificationType::FIELD_NOTIFICATION_DESCRIPTION => 'Generic Notification.',
            NotificationType::FIELD_ICON => 'fa-envelope',
            NotificationType::FIELD_TYPE_CODE => 'GEN-NOT',
            NotificationType::FIELD_TYPE => 'GEN',
            NotificationType::FIELD_SUB_TYPE => 'NOT',
        ];

        $this->validateInitialise($expected, $this->NotificationTypes, 7);
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
            NotificationType::FIELD_NOTIFICATION_TYPE,
            NotificationType::FIELD_ICON,
            NotificationType::FIELD_NOTIFICATION_DESCRIPTION,
            NotificationType::FIELD_TYPE_CODE,
        ];

        $this->validateRequired($required, $this->NotificationTypes, [$this, 'getGood']);

        $notEmpties = [
            NotificationType::FIELD_NOTIFICATION_TYPE,
            NotificationType::FIELD_ICON,
            NotificationType::FIELD_NOTIFICATION_DESCRIPTION,
            NotificationType::FIELD_TYPE_CODE,
        ];

        $this->validateNotEmpties($notEmpties, $this->NotificationTypes, [$this, 'getGood']);

        $maxLengths = [
            'notification_description' => 255,
            'notification_type' => 45,
            'icon' => 45,
            'type_code' => 7,
        ];

        $this->validateMaxLengths($maxLengths, $this->NotificationTypes, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->validateUniqueRule(
            NotificationType::FIELD_NOTIFICATION_TYPE,
            $this->NotificationTypes,
            [$this, 'getGood']
        );

        $this->validateUniqueRule(
            NotificationType::FIELD_TYPE_CODE,
            $this->NotificationTypes,
            [$this, 'getGood']
        );
    }

    /**
     * Test installBaseStatuses method
     *
     * @return void
     */
    public function testInstallBaseTypes()
    {
        $this->validateInstallBase($this->NotificationTypes);
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
