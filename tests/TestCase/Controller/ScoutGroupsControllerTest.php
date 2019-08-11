<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\ScoutGroupsController Test Case
 *
 * @uses \App\Controller\ScoutGroupsController
 */
class ScoutGroupsControllerTest extends TestCase
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
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.SectionTypes',
        'app.ScoutGroups',
        'app.Audits',
        'app.Roles',
    ];

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'ScoutGroups';

    /**
     * Test index method
     *
     * @return void
     *
     * @throws
     */
    public function testIndex()
    {
        $this->tryIndexGet($this->controller);
    }

    /**
     * Test view method
     *
     * @return void
     *
     * @throws
     */
    public function testView()
    {
        $this->tryViewGet($this->controller);
    }

    /**
     * Test add method
     *
     * @return void
     *
     * @throws
     */
    public function testAdd()
    {
        $this->tryAddGet($this->controller);

        $this->tryAddPost(
            $this->controller,
            [
                'scout_group' => '4th Goatville',
                'group_alias' => '4th Goat',
                'number_stripped' => 4,
                'charity_number' => 12345,
                'group_domain' => 'https://4thgoat.com',
            ],
            2
        );
    }

    /**
     * Test edit method
     *
     * @return void
     *
     * @throws
     */
    public function testEdit()
    {
        $this->tryEditGet($this->controller);

        $this->tryEditPost(
            $this->controller,
            [
                'scout_group' => '4th Goatville',
                'group_alias' => '4th Goat',
                'number_stripped' => 4,
                'charity_number' => 12345,
                'group_domain' => 'https://4thgoat.com',
            ],
            1
        );
    }

    /**
     * Test delete method
     *
     * @return void
     *
     * @throws
     */
    public function testDelete()
    {
        $this->tryDeletePost(
            $this->controller,
            [
                'scout_group' => '4th Goatville',
                'group_alias' => '4th Goat',
                'number_stripped' => 4,
                'charity_number' => 12345,
                'group_domain' => 'https://4thgoat.com',
            ],
            2
        );
    }
}
