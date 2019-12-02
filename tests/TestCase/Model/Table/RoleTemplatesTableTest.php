<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\RoleTemplate;
use App\Model\Table\RoleTemplatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RoleTemplatesTable Test Case
 */
class RoleTemplatesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\RoleTemplatesTable
     */
    public $RoleTemplates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RoleTemplates',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RoleTemplates') ? [] : ['className' => RoleTemplatesTable::class];
        $this->RoleTemplates = TableRegistry::getTableLocator()->get('RoleTemplates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RoleTemplates);

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
        return [
            RoleTemplate::FIELD_ROLE_TEMPLATE => 'Template ' . random_int(1, 999) . random_int(1, 99),
            RoleTemplate::FIELD_INDICATIVE_LEVEL => 2,
            RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => [],
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
            RoleTemplate::FIELD_ID => 1,
            RoleTemplate::FIELD_ROLE_TEMPLATE => 'Lorem ipsum dolor sit amet',
            RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => '',
            RoleTemplate::FIELD_INDICATIVE_LEVEL => 1
        ];
        $this->validateInitialise($expected, $this->RoleTemplates, 1);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->RoleTemplates->newEntity($good);
        TestCase::assertInstanceOf($this->RoleTemplates->getEntityClass(), $this->RoleTemplates->save($new));

        $required = [
            RoleTemplate::FIELD_ROLE_TEMPLATE,
            RoleTemplate::FIELD_INDICATIVE_LEVEL,
            RoleTemplate::FIELD_TEMPLATE_CAPABILITIES,
        ];
        $this->validateRequired($required, $this->RoleTemplates, [$this, 'getGood']);

        $notEmpties = [
            RoleTemplate::FIELD_ROLE_TEMPLATE,
            RoleTemplate::FIELD_INDICATIVE_LEVEL,
        ];
        $this->validateNotEmpties($notEmpties, $this->RoleTemplates, [$this, 'getGood']);

        $empties = [
            RoleTemplate::FIELD_TEMPLATE_CAPABILITIES,
        ];
        $this->validateEmpties($empties, $this->RoleTemplates, [$this, 'getGood']);

        $maxLengths = [
            RoleTemplate::FIELD_ROLE_TEMPLATE => 63
        ];
        $this->validateMaxLengths($maxLengths, $this->RoleTemplates, [$this, 'getGood']);
    }
}
