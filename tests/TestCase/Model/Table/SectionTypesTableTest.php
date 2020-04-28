<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SectionTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\SectionTypesTable Test Case
 */
class SectionTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SectionTypesTable
     */
    public $SectionTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SectionTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SectionTypes') ? [] : ['className' => SectionTypesTable::class];
        $this->SectionTypes = TableRegistry::getTableLocator()->get('SectionTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SectionTypes);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    private function getGood()
    {
        $good = [
            'section_type' => 'Llamas',
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
        $actual = $this->SectionTypes->get(1)->toArray();

        $expected = [
            'id' => 1,
            'section_type' => 'Beavers',
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->SectionTypes->find('all')->count();
        TestCase::assertEquals(8, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->SectionTypes->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\SectionType', $this->SectionTypes->save($new));

        $required = [
            'section_type',
        ];

        foreach ($required as $require) {
            $reqArray = $good;
            unset($reqArray[$require]);
            $new = $this->SectionTypes->newEntity($reqArray);
            TestCase::assertFalse($this->SectionTypes->save($new));
        }

        $empties = [
        ];

        foreach ($empties as $empty) {
            $reqArray = $good;
            $reqArray[$empty] = '';
            $new = $this->SectionTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\SectionType', $this->SectionTypes->save($new));
        }

        $notEmpties = [
            'section_type',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $good;
            $reqArray[$not_empty] = '';
            $new = $this->SectionTypes->newEntity($reqArray);
            TestCase::assertFalse($this->SectionTypes->save($new));
        }

        $maxLengths = [
            'section_type' => 255,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->SectionTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\SectionType', $this->SectionTypes->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->SectionTypes->newEntity($reqArray);
            TestCase::assertFalse($this->SectionTypes->save($new));
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

        $existing = $this->SectionTypes->get(1)->toArray();

        $values['section_type'] = 'Llamas';
        $new = $this->SectionTypes->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\SectionType', $this->SectionTypes->save($new));

        $values['section_type'] = $existing['section_type'];
        $new = $this->SectionTypes->newEntity($values);
        TestCase::assertFalse($this->SectionTypes->save($new));
    }
}
