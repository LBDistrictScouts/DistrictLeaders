<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Behavior;

use App\Model\Entity\User;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\CaseableBehavior Test Case
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class CaseableBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Behavior\CaseableBehavior
     */
    public $Caseable;

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

    public function provideInitialisation(): array
    {
        return [
            'Lower Case' => [
                User::FIELD_EMAIL,
                'JACOB.AgT.yler@lLamA.COM',
                'jacob.agt.yler@llama.com',
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
    public function testInitialization(string $field, string $beforeValue, string $expected)
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
