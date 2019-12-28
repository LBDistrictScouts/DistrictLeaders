<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\CampsController Test Case
 *
 * @uses \App\Controller\CampsController
 */
class CampsControllerTest extends TestCase
{
    use AppTestTrait;

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
    ];

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'Camps';

    /**
     * @var array $campData Valid creation Data.
     */
    private $campData = [
        'camp_name' => 'Test New Camp',
        'camp_type_id' => 1,
        'camp_start' => [
            'year' => 2019,
            'month' => 8,
            'day' => 12,
            'hour' => 9,
            'minute' => 53,
        ],
        'camp_end' => [
            'year' => 2019,
            'month' => 8,
            'day' => 11,
            'hour' => 9,
            'minute' => 53,
        ],
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
        $this->tryAddGet($this->controller);

        $this->tryAddPost(
            $this->controller,
            $this->campData,
            3
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
            $this->campData,
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
        $this->tryDeletePost(
            $this->controller,
            $this->campData,
            3
        );
    }
}
