<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Users',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.SectionTypes',
        'app.ScoutGroups',
        'app.Audits',
        'app.Roles',
        'app.Capabilities',
        'app.CapabilitiesRoleTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = TableRegistry::getTableLocator()->get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Users);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test retrieveCapabilities method
     *
     * @return void
     */
    public function testRetrieveAllCapabilities()
    {
        $user = $this->Users->get(1);
        $capabilities = $this->Users->retrieveAllCapabilities($user);

        $expected = [
	        'user' => [
		        (int) 6 => 'ALL',
		        (int) 4 => 'EDIT_GROUP',
		        (int) 1 => 'LOGIN',
		        (int) 0 => 'OWN_USER'
	        ],
	        'group' => [
		        (int) 1 => [
			        (int) 0 => 'EDIT_SECT'
		        ]
	        ],
	        'section' => [
		        (int) 1 => [
			        (int) 0 => 'EDIT_USER'
		        ]
	        ]
        ];

        $this->assertEquals($expected, $capabilities);

        $user = $this->Users->get(2);
        $capabilities = $this->Users->retrieveAllCapabilities($user);

        $expected = [
	        'user' => [
		        (int) 0 => 'LOGIN'
	        ],
	        'group' => [
		        (int) 1 => [
			        (int) 0 => 'EDIT_SECT'
		        ]
	        ],
	        'section' => [
		        (int) 2 => [
			        (int) 0 => 'EDIT_USER'
		        ],
		        (int) 1 => [
			        (int) 0 => 'EDIT_USER'
		        ]
	        ]
        ];

        $this->assertEquals($expected, $capabilities);
    }


	/**
	 * Test retrieveCapabilities method
	 *
	 * @return void
	 */
	public function testRetrieveCapabilities()
	{
		$user = $this->Users->get(1);
		$capabilities = $this->Users->retrieveCapabilities($user);

		$expected = [
			'user' => [
				(int) 6 => 'ALL',
				(int) 4 => 'EDIT_GROUP',
				(int) 1 => 'LOGIN',
				(int) 0 => 'OWN_USER'
			],
			'group' => [
				(int) 1 => [
					(int) 0 => 'EDIT_SECT'
				]
			],
			'section' => [
				(int) 1 => [
					(int) 0 => 'EDIT_USER'
				]
			]
		];

		$this->assertEquals($expected, $capabilities);

		$user = $this->Users->get(2);
		$capabilities = $this->Users->retrieveCapabilities($user);

		$expected = [
			'user' => [
				(int) 0 => 'LOGIN'
			],
			'group' => [
				(int) 1 => [
					(int) 0 => 'EDIT_SECT'
				]
			],
			'section' => [
				(int) 2 => [
					(int) 0 => 'EDIT_USER'
				],
				(int) 1 => [
					(int) 0 => 'EDIT_USER'
				]
			]
		];

		$this->assertEquals($expected, $capabilities);
	}

    /**
     * Test userCapability method
     *
     * @return void
     */
    public function testUserCapability()
    {
        // Basic Assert Positive
        $user = $this->Users->get(1);
        $cap = 'OWN_USER';

        $result = $this->Users->userCapability($user, $cap);
        $this->assertTrue($result);

        // Basic Assert Negative
        $user = $this->Users->get(2);
        $cap = 'OWN_USER';

        $result = $this->Users->userCapability($user, $cap);
        $this->assertFalse($result);

        // Sections
        $user = $this->Users->get(2);
        $cap = 'EDIT_USER';

        $result = $this->Users->userCapability($user, $cap);
        $this->assertArrayHasKey('sections', $result);

        $expected = [
	        'sections' => [
		        (int) 0 => (int) 2,
		        (int) 1 => (int) 1
	        ],
	        'groups' => []
        ];
        $this->assertEquals($expected, $result);

        // Groups
        $user = $this->Users->get(2);
        $cap = 'EDIT_SECT';

        $result = $this->Users->userCapability($user, $cap);
        $this->assertArrayHasKey('groups', $result);

	    $expected = [
		    'sections' => [],
		    'groups' => [
			    (int) 0 => (int) 1
		    ]
	    ];
	    $this->assertEquals($expected, $result);
    }
}
