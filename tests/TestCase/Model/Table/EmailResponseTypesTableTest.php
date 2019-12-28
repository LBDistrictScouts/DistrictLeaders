<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailResponseTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\EmailResponseTypesTable Test Case
 */
class EmailResponseTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailResponseTypesTable
     */
    public $EmailResponseTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmailResponseTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailResponseTypes') ? [] : ['className' => EmailResponseTypesTable::class];
        $this->EmailResponseTypes = TableRegistry::getTableLocator()->get('EmailResponseTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailResponseTypes);

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
            'email_response_type' => 'Type' . random_int(1111, 9999),
            'bounce' => true,
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
        $actual = $this->EmailResponseTypes->get(1)->toArray();

        $expected = [
            'id' => 1,
            'email_response_type' => 'Email Open',
            'bounce' => true,
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->EmailResponseTypes->find('all')->count();
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

        $new = $this->EmailResponseTypes->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\EmailResponseType', $this->EmailResponseTypes->save($new));

        $required = [
            'email_response_type',
            'bounce',
        ];

        foreach ($required as $require) {
            $reqArray = $good;
            unset($reqArray[$require]);
            $new = $this->EmailResponseTypes->newEntity($reqArray);
            TestCase::assertFalse($this->EmailResponseTypes->save($new));
        }

        $notEmpties = [
            'email_response_type',
            'bounce',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $good;
            $reqArray[$not_empty] = '';
            $new = $this->EmailResponseTypes->newEntity($reqArray);
            TestCase::assertFalse($this->EmailResponseTypes->save($new));
        }

        $maxLengths = [
            'email_response_type' => 255,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $maxLength) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $maxLength);
            $new = $this->EmailResponseTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\EmailResponseType', $this->EmailResponseTypes->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $maxLength + 1);
            $new = $this->EmailResponseTypes->newEntity($reqArray);
            TestCase::assertFalse($this->EmailResponseTypes->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     *
     * @throws
     */
    public function testBuildRules()
    {
        $values = $this->getGood();

        $existing = $this->EmailResponseTypes->get(1)->toArray();

        $values['email_response_type'] = 'My new Camp Role Type';
        $new = $this->EmailResponseTypes->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\EmailResponseType', $this->EmailResponseTypes->save($new));

        $values['email_response_type'] = $existing['email_response_type'];
        $new = $this->EmailResponseTypes->newEntity($values);
        TestCase::assertFalse($this->EmailResponseTypes->save($new));
    }
}
