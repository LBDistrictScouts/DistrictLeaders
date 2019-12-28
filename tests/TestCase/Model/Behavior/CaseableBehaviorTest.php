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
        'app.PasswordStates',
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
        'app.Notifications',
        'app.NotificationTypes',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',
    ];

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->Users = $this->getTableLocator()->get('Users');

        $testArray = [
            User::FIELD_EMAIL => 'JACOB.AgT.yler@lLamA.COM',
            User::FIELD_POSTCODE => 'sg7 1Lm',
            User::FIELD_FIRST_NAME => 'JOSEPH',
        ];

        foreach ($testArray as $field => $value) {
            $user = $this->Users->get(1);

            $user->set($field, $value);
            TestCase::assertNotFalse($this->Users->save($user));

            $user = $this->Users->get(1);
            TestCase::assertNotEquals($value, $user->get($field));
            TestCase::assertEquals(strtoupper($value), strtoupper($user->get($field)));
        }
    }
}
