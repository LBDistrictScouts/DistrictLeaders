<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\CaseableBehavior;
use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use App\Test\Fixture\FixtureTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\CaseableBehavior Test Case
 */
class CaseableBehaviorTest extends TestCase
{
    use FixtureTestTrait;

    /**
     * @var UsersTable
     */
    public UsersTable $Users;

    /**
     * Test subject
     *
     * @var CaseableBehavior
     */
    public CaseableBehavior $Caseable;

    public function provideInitialisation(): array
    {
        return [
            'Lower Case' => [
                User::FIELD_EMAIL,
                'JACOBAgT+yler@8thfish.co.uk',
                'jacobagt+yler@8thfish.co.uk',
            ],
            'Upper Case' => [
                User::FIELD_POSTCODE,
                'sg7 1Lm',
                'SG7 1LM',
            ],
            'Title Case' => [
                User::FIELD_CITY,
                'LETCHworth',
                'Letchworth',
            ],
            'Proper Case' => [
                User::FIELD_FIRST_NAME,
                'JOE-DEE',
                'Joe-Dee',
            ],
        ];
    }

    /**
     * Test initial setup
     *
     * @param string $field The Field to be tested
     * @param string $beforeValue The Start Value
     * @param string $expected The Output Expected
     * @dataProvider provideInitialisation
     * @return void
     */
    public function testInitialization(string $field, string $beforeValue, string $expected): void
    {
        $this->Users = $this->getTableLocator()->get('Users');
        $user = $this->Users->get(1);

        $user->set($field, $beforeValue);
        TestCase::assertNotFalse($this->Users->save($user));

        $user = $this->Users->get(1);
        TestCase::assertEquals($expected, $user->get($field));
        TestCase::assertNotEquals($beforeValue, $user->get($field));
        TestCase::assertEquals(strtoupper($beforeValue), strtoupper($user->get($field)));
    }
}
