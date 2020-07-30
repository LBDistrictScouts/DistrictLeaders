<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Audit;
use App\Model\Table\AuditsTable;
use Cake\I18n\Time;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AuditsTable Test Case
 */
class AuditsTableTest extends TestCase
{
    use ModelTestTrait;
    use LocatorAwareTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\AuditsTable
     */
    public $Audits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Audits') ? [] : ['className' => AuditsTable::class];
        $this->Audits = $this->getTableLocator()->get('Audits', $config);

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
        unset($this->Audits);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    private function getGood()
    {
        $date = Time::getTestNow();
        $good = [
            'audit_field' => 'last_name',
            'audit_table' => 'Users',
            'original_value' => 'old',
            'modified_value' => 'new',
            'audit_record_id' => '1',
            'user_id' => 1,
            'change_date' => $date,
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
        $expected = [
            'id' => 1,
            'audit_field' => 'first_name',
            'audit_table' => 'Users',
            'original_value' => 'old',
            'modified_value' => 'new',
            'user_id' => 1,
            'audit_record_id' => 1,
        ];
        $this->validateInitialise($expected, $this->Audits, 1, ['change_date']);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->Audits->newEntity($good);
        TestCase::assertInstanceOf(Audit::class, $this->Audits->save($new));

        $required = [
            Audit::FIELD_AUDIT_FIELD,
            Audit::FIELD_AUDIT_TABLE,
            Audit::FIELD_MODIFIED_VALUE,
        ];

        $this->validateRequired($required, $this->Audits, [$this, 'getGood']);

        $empties = [
            Audit::FIELD_ORIGINAL_VALUE,
        ];
        $this->validateEmpties($empties, $this->Audits, [$this, 'getGood']);

        $notEmpties = [
            Audit::FIELD_MODIFIED_VALUE,
            Audit::FIELD_AUDIT_TABLE,
            Audit::FIELD_AUDIT_FIELD,
        ];

        $this->validateNotEmpties($notEmpties, $this->Audits, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->validateExistsRule(Audit::FIELD_USER_ID, $this->Audits, $this->Audits->Users, [$this, 'getGood']);
    }
}
