<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Token;
use App\Model\Table\TokensTable;
use App\Utility\TextSafe;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TokensTable Test Case
 */
class TokensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TokensTable
     */
    public $Tokens;

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
        'app.CampRoleTypes',
        'app.CampRoles',
        'app.Camps',
        'app.CampTypes',
        'app.Notifications',
        'app.NotificationTypes',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Tokens') ? [] : ['className' => TokensTable::class];
        $this->Tokens = TableRegistry::getTableLocator()->get('Tokens', $config);

        $now = new FrozenTime('2016-12-26 23:22:30');
        FrozenTime::setTestNow($now);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tokens);

        parent::tearDown();
    }

    /**
     * Get Good Entity Data
     *
     * @return array
     *
     * @throws
     */
    private function getGood()
    {
        return [
            'token' => 'Password Reset for Jacob',
            'email_send_id' => 1,
            'active' => true,
            'random_number' => 1789,
            'token_header' => [
                'redirect' => [
                    'controller' => 'Applications',
                    'action' => 'view',
                    'prefix' => false,
                    1
                ],
                'authenticate' => true,
            ]
        ];
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $actual = $this->Tokens->get(1)->toArray();

        $dates = [
            'expires',
            'created',
            'modified',
            'utilised',
            'deleted',
        ];

        foreach ($dates as $date) {
            $dateValue = $actual[$date];
            if (!is_null($dateValue)) {
                TestCase::assertInstanceOf('Cake\I18n\FrozenTime', $dateValue);
            }
            unset($actual[$date]);
        }

        $expected = [
            'id' => 1,
            'email_send_id' => 1,
            'active' => true,
            'random_number' => 54498,
            'token_header' => [
                'redirect' => [
                    'controller' => 'Applications',
                    'action' => 'view',
                    'prefix' => false,
                    1
                ],
                'authenticate' => false,
            ]
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->Tokens->find('all')->count();
        TestCase::assertEquals(1, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->Tokens->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\Token', $this->Tokens->save($new));

        $required = [
            'token',
            'token_header',
        ];

        foreach ($required as $require) {
            $reqArray = $this->getGood();
            unset($reqArray[$require]);
            $new = $this->Tokens->newEntity($reqArray);
            TestCase::assertFalse($this->Tokens->save($new));
        }

        $notRequired = [
            'expires',
            'utilised',
        ];

        foreach ($notRequired as $notRequire) {
            $reqArray = $this->getGood();
            unset($reqArray[$notRequire]);
            $new = $this->Tokens->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\Token', $this->Tokens->save($new));
        }

        $empties = [
            'expires',
            'utilised',
        ];

        foreach ($empties as $empty) {
            $reqArray = $this->getGood();
            $reqArray[$empty] = '';
            $new = $this->Tokens->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\Token', $this->Tokens->save($new));
        }

        $notEmpties = [
            'token',
            'token_header',
        ];

        foreach ($notEmpties as $notEmpty) {
            $reqArray = $this->getGood();
            $reqArray[$notEmpty] = '';
            $new = $this->Tokens->newEntity($reqArray);
            TestCase::assertFalse($this->Tokens->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Email Send Exists
        $values = $this->getGood();

        $sends = $this->Tokens->EmailSends->find('list')->toArray();

        $send = max(array_keys($sends));

        $values['email_send_id'] = $send;
        $new = $this->Tokens->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\Token', $this->Tokens->save($new));

        $values['email_send_id'] = $send + 1;
        $new = $this->Tokens->newEntity($values);
        TestCase::assertFalse($this->Tokens->save($new));
    }

    /**
     * Test the Build Token
     */
    public function testBuildToken()
    {
        $token = $this->Tokens->buildToken(1);
        $token = urldecode($token);
        $token = TextSafe::decode($token);

        TestCase::assertGreaterThanOrEqual(32, strlen($token), 'Token is too short.');

        $decrypter = substr($token, 0, 8);
        TestCase::assertEquals(8, strlen($decrypter));

        $token = substr($token, 8);

        $token = base64_decode($token);
        $token = json_decode($token);

        $data = [
            'id' => 1,
            'random_number' => 54498,
        ];

        TestCase::assertEquals($data['id'], $token->id);

        TestCase::assertEquals($data['random_number'], $token->random_number);
        TestCase::assertTrue(is_numeric($token->random_number));
    }

    /**
     * Test Before Save Function
     */
    public function testBeforeSave()
    {
        $goodData = [
            'email_send_id' => 1,
            'active' => true,
            'token' => 'GOAT',
            'token_header' => [
                'redirect' => [
                    'controller' => 'Applications',
                    'action' => 'view',
                    'prefix' => false,
                ],
                'authenticate' => true,
            ]
        ];

        $expected = [
            'id' => 2,
            'email_send_id' => 1,
            'active' => true,
            'token_header' => [
                'redirect' => [
                    'controller' => 'Applications',
                    'action' => 'view',
                    'prefix' => false,
                ],
                'authenticate' => true,
            ]
        ];

        $goodEntity = $this->Tokens->newEntity($goodData);

        $this->Tokens->save($goodEntity);

        $query = $this->Tokens->get(2, [
            'fields' => [
                'id',
                'email_send_id',
                'active',
                'token_header',
            ]
        ]);

        $result = $query->toArray();

        TestCase::assertEquals($expected, $result);

        $query = $this->Tokens->get(2, [
            'fields' => [
                'random_number',
                'active'
            ]
        ]);

        $result = $query->toArray();

        TestCase::assertTrue(is_numeric($result['random_number']));
        TestCase::assertTrue($result['active']);
    }

    /**
     * Test validate Token Function
     */
    public function testValidateToken()
    {
        $goodData = [
            'email_send_id' => 1,
            'active' => true,
            'token' => 'GOAT',
            'token_header' => [
                'redirect' => [
                    'controller' => 'Applications',
                    'action' => 'view',
                    'prefix' => false,
                ],
                'authenticate' => true,
            ]
        ];

        $expected = [
            'id' => 2,
            'email_send_id' => 1,
            'active' => true,
        ];

        $goodEntity = $this->Tokens->newEntity($goodData, ['accessibleFields' => ['id' => true]]);

        $this->Tokens->save($goodEntity);

        $query = $this->Tokens->get(2, [
            'fields' => [
                'id',
                'email_send_id',
                'active',
            ]
        ]);

        $result = $query->toArray();

        TestCase::assertEquals($expected, $result);

        $query = $this->Tokens->get(2, [
            'fields' => [
                'random_number',
                'active'
            ]
        ]);

        $result = $query->toArray();

        TestCase::assertTrue(is_numeric($result['random_number']));
        TestCase::assertTrue($result['active']);

        $token = $this->Tokens->buildToken(2);

        $result = $this->Tokens->validateToken($token);

        TestCase::assertNotFalse($result);
        TestCase::assertTrue(is_numeric($result));

        $incorrectToken = substr($token, 25, 256);

        $result = $this->Tokens->validateToken($incorrectToken);

        TestCase::assertFalse($result);
        TestCase::assertNotTrue(is_numeric($result));
    }

    /**
     * Test Clean Token Function
     */
    public function testCleanToken()
    {
        $now = new FrozenTime('2019-01-01 00:01:00');
        FrozenTime::setTestNow($now);

        $expected = new FrozenTime('2019-04-30 11:26:44');
        $token = $this->Tokens->get(1);
        TestCase::assertEquals($expected, $token->get(Token::FIELD_EXPIRES));

        $result = $this->Tokens->cleanToken($token);
        TestCase::assertEquals(TokensTable::CLEAN_NO_CLEAN, $result);

        $now = $expected->addMonth()->addDay();
        FrozenTime::setTestNow($now);

        $result = $this->Tokens->cleanToken($token);
        TestCase::assertEquals(TokensTable::CLEAN_DEACTIVATE, $result);

        $token = $this->Tokens->get(1);
        TestCase::assertFalse($token->get(Token::FIELD_ACTIVE));

        $now = $now->addMonth();
        FrozenTime::setTestNow($now);

        $result = $this->Tokens->cleanToken($token);
        TestCase::assertEquals(TokensTable::CLEAN_DELETED, $result);

        $this->expectException('Cake\Datasource\Exception\RecordNotFoundException');
        $this->Tokens->get(1);
    }

    public function testCleanAllTokens()
    {
        $now = new FrozenTime('2019-01-01 00:01:00');
        FrozenTime::setTestNow($now);

        $requiredReturn = [
            'no_change' => 1,
            'deactivated' => 0,
            'deleted' => 0,
        ];
        TestCase::assertEquals($requiredReturn, $this->Tokens->cleanAllTokens());

        $expected = new FrozenTime('2019-04-30 11:26:44');
        $now = $expected->addMonth()->addDay();
        FrozenTime::setTestNow($now);

        $requiredReturn = [
            'no_change' => 0,
            'deactivated' => 1,
            'deleted' => 0,
        ];
        TestCase::assertEquals($requiredReturn, $this->Tokens->cleanAllTokens());

        $now = $now->addMonth();
        FrozenTime::setTestNow($now);

        $requiredReturn = [
            'no_change' => 0,
            'deactivated' => 0,
            'deleted' => 1,
        ];
        TestCase::assertEquals($requiredReturn, $this->Tokens->cleanAllTokens());

        TestCase::assertEquals(0, $this->Tokens->find()->count());
    }
}
