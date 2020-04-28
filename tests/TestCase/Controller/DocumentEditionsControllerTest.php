<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Entity\DocumentEdition;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\DocumentEditionsController Test Case
 *
 * @uses \App\Controller\DocumentEditionsController
 */
class DocumentEditionsControllerTest extends TestCase
{
    use AppTestTrait;

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
        'app.Notifications',
        'app.NotificationTypes',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',
        'app.FileTypes',
        'app.DocumentTypes',
        'app.Documents',
        'app.DocumentVersions',
        'app.DocumentEditions',
    ];

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'DocumentEditions';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private $validEntityData = [
        DocumentEdition::FIELD_DOCUMENT_VERSION_ID => 1,
        DocumentEdition::FIELD_FILE_TYPE_ID => 2,
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->tryIndexGet($this->controller);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->tryViewGet($this->controller);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        TestCase::markTestIncomplete();
        $this->tryGet([
            'controller' => $this->controller,
            'action' => 'upload',
        ]);

        $this->tryPost(
            [
                'controller' => $this->controller,
                'action' => 'upload',
            ],
            $this->validEntityData,
            [
                'controller' => $this->controller,
                'action' => 'index',
            ]
        );
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->tryEditGet($this->controller);

        $this->tryEditPost(
            $this->controller,
            $this->validEntityData,
            1
        );
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        TestCase::markTestIncomplete();
        $this->tryDeletePost(
            $this->controller,
            $this->validEntityData,
            2
        );
    }
}
