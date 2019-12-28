<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Behavior;

use App\Model\Entity\Audit;
use App\Model\Entity\User;
use Cake\Event\EventList;
use Cake\Event\EventManager;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\AuditableBehavior Test Case
 *
 * @property \App\Model\Table\AuditsTable $Audits
 * @property \App\Model\Table\UsersTable $Users
 *
 * @property EventManager $EventManager
 */
class AuditableBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Behavior\AuditableBehavior
     */
    public $Auditable;

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
        $this->EventManager = EventManager::instance();
        $this->EventManager->setEventList(new EventList());

        $this->Users = $this->getTableLocator()->get('Users');
        $this->Audits = $this->getTableLocator()->get('Audits');

        $auditCount = $this->Audits->find('all')->count();

        $user = $this->Users->get(1);
        $name = 'Johnny';
        $user->set(User::FIELD_FIRST_NAME, $name);
        TestCase::assertNotFalse($this->Users->save($user));

        $this->assertEventFired('Model.afterSave', $this->EventManager);

        $afterAuditCount = $this->Audits->find('all')->count();
        TestCase::assertNotEquals($auditCount, $afterAuditCount);
        $auditCount += 1;
        TestCase::assertEquals($auditCount, $afterAuditCount);

        $latest = $this->Audits->find('all')->orderDesc('id')->first();

        TestCase::assertEquals(User::FIELD_FIRST_NAME, $latest->get(Audit::FIELD_AUDIT_FIELD));
        TestCase::assertEquals('Users', $latest->get(Audit::FIELD_AUDIT_TABLE));
        TestCase::assertEquals('Lorem ipsum dolor sit amet', $latest->get(Audit::FIELD_ORIGINAL_VALUE));
        TestCase::assertEquals($name, $latest->get(Audit::FIELD_MODIFIED_VALUE));

        $this->assertEventFired('Model.User.newAudits', $this->EventManager);
    }
}
