<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\AuditableBehavior;
use App\Model\Entity\Audit;
use App\Model\Entity\User;
use App\Model\Entity\UserContact;
use App\Test\Fixture\FixtureTestTrait;
use Cake\Event\EventList;
use Cake\Event\EventManager;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\AuditableBehavior Test Case
 *
 * @property AuditsTable $Audits
 * @property UsersTable $Users
 *
 * @property EventManager $EventManager
 */
class AuditableBehaviorTest extends TestCase
{
    use FixtureTestTrait;

    /**
     * Test subject
     *
     * @var AuditableBehavior
     */
    public AuditableBehavior $Auditable;

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
        $auditCount += 2;
        TestCase::assertEquals($auditCount, $afterAuditCount);

        $latest = $this->Audits->find('all')->orderDesc(Audit::FIELD_ID)->toArray();

        // The After Save Event for the User Contact Primary Association
        TestCase::assertEquals(UserContact::FIELD_CONTACT_FIELD, $latest[0]->get(Audit::FIELD_AUDIT_FIELD));
        TestCase::assertEquals('UserContacts', $latest[0]->get(Audit::FIELD_AUDIT_TABLE));
        TestCase::assertEquals(null, $latest[0]->get(Audit::FIELD_ORIGINAL_VALUE));
        TestCase::assertEquals('fish@4thgoat.org.uk', $latest[0]->get(Audit::FIELD_MODIFIED_VALUE));

        // The Changed Audit
        TestCase::assertEquals(User::FIELD_FIRST_NAME, $latest[1]->get(Audit::FIELD_AUDIT_FIELD));
        TestCase::assertEquals('Users', $latest[1]->get(Audit::FIELD_AUDIT_TABLE));
        TestCase::assertEquals('Lorem ipsum dolor sit amet', $latest[1]->get(Audit::FIELD_ORIGINAL_VALUE));
        TestCase::assertEquals($name, $latest[1]->get(Audit::FIELD_MODIFIED_VALUE));

        $this->assertEventFired('Model.Users.newAudits', $this->EventManager);
    }
}
