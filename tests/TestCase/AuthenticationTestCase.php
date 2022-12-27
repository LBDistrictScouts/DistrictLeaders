<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link https://cakephp.org CakePHP(tm) Project
 * @since 1.0.0
 * @license https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase;

use App\Model\Entity\User;
use App\Test\Fixture\FixtureTestTrait;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * Class AuthenticationTestCase
 *
 * @package App\Test\TestCase
 */
class AuthenticationTestCase extends TestCase
{
    use LocatorAwareTrait;
    use FixtureTestTrait;

    /**
     * @var string The Plain Password Value
     */
    protected $plainPassword = 'password';

    /**
     * @var string The Variable for Standard Testcase Username
     */
    protected $username = 'mariano';

    /**
     * @var string The Hashed Password Value
     */
    protected $password;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        Security::setSalt('YJfIxfs2guVoUubWDYhG93b0qyJfIxfs2guwvniR2G0FgaC9mi');

        $this->password = password_hash($this->plainPassword, PASSWORD_DEFAULT);

        $this->setupUsersAndPasswords();
    }

    /**
     * _setupUsersAndPasswords
     *
     * @return void
     */
    protected function setupUsersAndPasswords()
    {
        $users = $this->getTableLocator()->get('Users');

        $user = $users->get(1)->set(User::FIELD_USERNAME, $this->username);
        $users->save($user);

        $users->updateAll(['password' => $this->password], []);
    }
}
