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
     * @var NotificationTypesTable
     */
    protected NotificationTypesTable $NotificationTypes;

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
            NotificationType::FIELD_CONTENT_TEMPLATE => 'welcome',
        ];
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $expected = [
            NotificationType::FIELD_ID => 1,
            NotificationType::FIELD_NOTIFICATION_TYPE => 'Generic',
            NotificationType::FIELD_NOTIFICATION_DESCRIPTION => 'Generic Notification.',
            NotificationType::FIELD_ICON => 'fa-envelope',
            NotificationType::FIELD_TYPE_CODE => 'GEN-NOT',
            NotificationType::FIELD_TYPE => 'GEN',
            NotificationType::FIELD_SUB_TYPE => 'NOT',
            NotificationType::FIELD_CONTENT_TEMPLATE => 'standard',
            NotificationType::FIELD_REPETITIVE => false,
        ];

        $this->validateInitialise($expected, $this->NotificationTypes, 7);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $good = $this->getGood();

        $new = $this->NotificationTypes->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\NotificationType', $this->NotificationTypes->save($new));

        $required = [
            NotificationType::FIELD_NOTIFICATION_TYPE,
            NotificationType::FIELD_ICON,
            NotificationType::FIELD_NOTIFICATION_DESCRIPTION,
            NotificationType::FIELD_TYPE_CODE,
            NotificationType::FIELD_CONTENT_TEMPLATE,
        ];

        $this->validateRequired($required, $this->NotificationTypes, [$this, 'getGood']);

        $notEmpties = [
            NotificationType::FIELD_NOTIFICATION_TYPE,
            NotificationType::FIELD_ICON,
            NotificationType::FIELD_NOTIFICATION_DESCRIPTION,
            NotificationType::FIELD_TYPE_CODE,
            NotificationType::FIELD_CONTENT_TEMPLATE,
        ];

        $this->validateNotEmpties($notEmpties, $this->NotificationTypes, [$this, 'getGood']);

        $maxLengths = [
            NotificationType::FIELD_NOTIFICATION_DESCRIPTION => 255,
            NotificationType::FIELD_NOTIFICATION_TYPE => 45,
            NotificationType::FIELD_ICON => 45,
            NotificationType::FIELD_TYPE_CODE => 7,
            NotificationType::FIELD_CONTENT_TEMPLATE => 32,
        ];

        $this->validateMaxLengths($maxLengths, $this->NotificationTypes, [$this, 'getGood']);

        $regex = [
            NotificationType::FIELD_TYPE_CODE => [
                TextSafe::shuffle(3) . '-' . TextSafe::shuffle(3) => true,
                TextSafe::shuffle(4) . '-' . TextSafe::shuffle(3) => false,
                TextSafe::shuffle(3) . '-' . TextSafe::shuffle(4) => false,
                TextSafe::shuffle(2) . '-' . TextSafe::shuffle(3) => false,
                TextSafe::shuffle(3) . '-' . TextSafe::shuffle(2) => false,
                TextSafe::shuffle(3) . '*' . TextSafe::shuffle(3) => false,
                TextSafe::shuffle(3) . '-' . TextSafe::shuffle(4) => false,
            ],
        ];

        $this->validateRegex($regex, $this->NotificationTypes, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
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
     * Test installBaseNotificationTypes method
     *
     * @return void
     */
    public function testInstallBaseNotificationTypes(): void
    {
        $this->validateInstallBase($this->NotificationTypes);
    }

    /**
     * Test getTypeCode method
     *
     * @return void
     */
    public function testGetTypeCode(): void
    {
        // Known
        /** @var NotificationType $type */
        foreach ($this->NotificationTypes->find() as $type) {
            /** @var array $codes */
            $codes = explode('-', $type->type_code);
            $actual = $this->NotificationTypes->getTypeCode($codes[0] . '-1-' . $codes[1]);
            TestCase::assertEquals($type, $actual);
        }

        // Generic
        $code = 'GEN-1-NOT';
        $expected = $this->NotificationTypes->getTypeCode($code);

        $code = 'NOT-1-' . TextSafe::shuffle(3);
        $actual = $this->NotificationTypes->getTypeCode($code);
        TestCase::assertEquals($expected, $actual);
    }

    /**
     * @return string[][]
     */
    public function provideCodeSplitter(): array
    {
        return [
            'Two Code' => [
                'USR-NEW',
                [
                    'type' => 'USR',
                    'subType' => 'NEW',
                    'entityId' => null,
                    'instance' => null,
                    'typeCode' => 'USR-NEW',
                    'codeBlocks' => 2,
                ],
            ],
            'Three Code' => [
                'USR-1-NEW',
                [
                    'type' => 'USR',
                    'subType' => 'NEW',
                    'entityId' => 1,
                    'instance' => null,
                    'typeCode' => 'USR-NEW',
                    'codeBlocks' => 3,
                ],
            ],
            'Four Code' => [
                'USR-1-NEW-1',
                [
                    'type' => 'USR',
                    'subType' => 'NEW',
                    'entityId' => 1,
                    'instance' => 1,
                    'typeCode' => 'USR-NEW',
                    'codeBlocks' => 4,
                ],
            ],
        ];
    }

    /**
     * Test getTypeCode method
     *
     * @dataProvider provideCodeSplitter
     * @param string $code Email Code
     * @param array $expectedReturn Broken Array
     * @return void
     */
    public function testCodeSplitter(string $code, array $expectedReturn): void
    {
        $result = $this->NotificationTypes->entityCodeSplitter($code);

        TestCase::assertEquals($expectedReturn, $result);
    }
}
