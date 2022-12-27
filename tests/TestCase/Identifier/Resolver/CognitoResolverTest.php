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
namespace App\Test\TestCase\Identifier\Resolver;

use App\Identifier\Resolver\CognitoResolver;
use App\Model\Entity\User;
use App\Test\TestCase\AuthenticationTestCase;
use Cake\Datasource\EntityInterface;

/**
 * Class OrmResolverTest
 *
 * @package App\Test\TestCase\Identifier\Resolver
 */
class CognitoResolverTest extends AuthenticationTestCase
{
    public function testFindDefault()
    {
        $resolver = new CognitoResolver();

        $user = $resolver->find([
            'username' => 'mariano',
        ]);

        static::assertInstanceOf(EntityInterface::class, $user);
        static::assertEquals('mariano', $user['username']);
    }

    public function testFindConfig()
    {
        $resolver = new CognitoResolver([
            'userModel' => 'Users',
            'finder' => [
                'all',
                'auth' => ['return_created' => true],
            ],
        ]);

        /** @var User $user */
        $user = $resolver->find([
            'username' => 'mariano',
        ]);

        static::assertNotEmpty($user->created);
    }

    public function testFindAnd()
    {
        $resolver = new CognitoResolver();

        $user = $resolver->find([
            'id' => 1,
            'username' => 'mariano',
        ]);

        static::assertEquals(1, $user['id']);
    }

    public function testFindOr()
    {
        $resolver = new CognitoResolver();

        $user = $resolver->find([
            'id' => 1,
            'username' => 'luigiano',
        ], 'OR');

        static::assertEquals(1, $user['id']);
    }

    public function testFindMissing()
    {
        $resolver = new CognitoResolver();

        $user = $resolver->find([
            'id' => 1,
            'username' => 'luigiano',
        ]);

        static::assertNull($user);
    }

    public function testFindMultipleValues()
    {
        $resolver = new CognitoResolver();

        $user = $resolver->find([
            'username' => [
                'luigiano',
                'mariano',
            ],
        ]);

        static::assertEquals(1, $user['id']);
    }
}
