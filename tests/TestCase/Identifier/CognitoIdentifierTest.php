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

namespace App\Test\TestCase\Identifier;

use App\Identifier\CognitoIdentifier;
use App\Test\TestCase\AuthenticationTestCase as TestCase;
use ArrayObject;
use Authentication\Identifier\Resolver\ResolverInterface;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Authentication\PasswordHasher\PasswordHasherInterface;

/**
 * Class PasswordIdentifierTest
 *
 * @package App\Test\TestCase\Identifier
 */
class CognitoIdentifierTest extends TestCase
{
    /**
     * testIdentifyValid
     *
     * @return void
     */
    public function testIdentifyValid()
    {
        $resolver = $this->createMock(ResolverInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);

        $user = new ArrayObject([
            'username' => 'mariano',
            'password' => 'h45hedpa55w0rd',
        ]);

        $resolver->expects(static::once())
            ->method('find')
            ->with(['username' => 'mariano'])
            ->willReturn($user);

        $hasher->expects(static::once())
            ->method('check')
            ->with('password', 'h45hedpa55w0rd')
            ->willReturn(true);

        $identifier = new CognitoIdentifier();
        $identifier->setResolver($resolver)->setPasswordHasher($hasher);

        $result = $identifier->identify([
            'username' => 'mariano',
            'password' => 'password',
        ]);

        static::assertInstanceOf('\ArrayAccess', $result);
        static::assertSame($user, $result);
    }

    /**
     * testIdentifyNeedsRehash
     *
     * @return void
     */
    public function testIdentifyNeedsRehash()
    {
        $resolver = $this->createMock(ResolverInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);

        $user = new ArrayObject([
            'username' => 'mariano',
            'password' => 'h45hedpa55w0rd',
        ]);

        $resolver->method('find')
            ->willReturn($user);

        $hasher->method('check')
            ->willReturn(true);

        $hasher->expects(static::once())
            ->method('needsRehash')
            ->with('h45hedpa55w0rd')
            ->willReturn(true);

        $identifier = new CognitoIdentifier();
        $identifier->setResolver($resolver)->setPasswordHasher($hasher);

        $result = $identifier->identify([
            'username' => 'mariano',
            'password' => 'password',
        ]);

        static::assertInstanceOf('\ArrayAccess', $result);
        static::assertTrue($identifier->needsPasswordRehash());
    }

    /**
     * testIdentifyInvalidUser
     *
     * @return void
     */
    public function testIdentifyInvalidUser()
    {
        $resolver = $this->createMock(ResolverInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);

        $resolver->expects(static::once())
            ->method('find')
            ->with(['username' => 'does-not'])
            ->willReturn(null);

        $hasher->expects(static::once())
            ->method('check')
            ->with('exist', '')
            ->willReturn(false);

        $identifier = new CognitoIdentifier();
        $identifier->setResolver($resolver)->setPasswordHasher($hasher);

        $result = $identifier->identify([
            'username' => 'does-not',
            'password' => 'exist',
        ]);

        static::assertNull($result);
    }

    /**
     * testIdentifyInvalidPassword
     *
     * @return void
     */
    public function testIdentifyInvalidPassword()
    {
        $resolver = $this->createMock(ResolverInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);

        $user = new ArrayObject([
            'username' => 'mariano',
            'password' => 'h45hedpa55w0rd',
        ]);

        $resolver->expects(static::once())
            ->method('find')
            ->with(['username' => 'mariano'])
            ->willReturn($user);

        $hasher->expects(static::once())
            ->method('check')
            ->with('wrongpassword', 'h45hedpa55w0rd')
            ->willReturn(false);

        $identifier = new CognitoIdentifier();
        $identifier->setResolver($resolver)->setPasswordHasher($hasher);

        $result = $identifier->identify([
            'username' => 'mariano',
            'password' => 'wrongpassword',
        ]);

        static::assertNull($result);
    }

    /**
     * testIdentifyEmptyPassword
     *
     * @return void
     */
    public function testIdentifyEmptyPassword()
    {
        $resolver = $this->createMock(ResolverInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);

        $user = new ArrayObject([
            'username' => 'mariano',
            'password' => 'h45hedpa55w0rd',
        ]);

        $resolver->expects(static::once())
            ->method('find')
            ->with(['username' => 'mariano'])
            ->willReturn($user);

        $hasher->expects(static::once())
            ->method('check')
            ->with('', 'h45hedpa55w0rd')
            ->willReturn(false);

        $identifier = new CognitoIdentifier();
        $identifier->setResolver($resolver)->setPasswordHasher($hasher);

        $result = $identifier->identify([
            'username' => 'mariano',
            'password' => '',
        ]);

        static::assertNull($result);
    }

    /**
     * testIdentifyNoPassword
     *
     * @return void
     */
    public function testIdentifyNoPassword()
    {
        $resolver = $this->createMock(ResolverInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);

        $user = new ArrayObject([
            'username' => 'mariano',
            'password' => 'h45hedpa55w0rd',
        ]);

        $resolver->expects(static::once())
            ->method('find')
            ->with(['username' => 'mariano'])
            ->willReturn($user);

        $hasher->expects(static::never())
            ->method('check');

        $identifier = new CognitoIdentifier();
        $identifier->setResolver($resolver)->setPasswordHasher($hasher);

        $result = $identifier->identify([
            'username' => 'mariano',
        ]);

        static::assertInstanceOf('\ArrayAccess', $result);
    }

    /**
     * testIdentifyMissingCredentials
     *
     * @return void
     */
    public function testIdentifyMissingCredentials()
    {
        $resolver = $this->createMock(ResolverInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);

        $resolver->expects(static::never())
            ->method('find');

        $hasher->expects(static::never())
            ->method('check');

        $identifier = new CognitoIdentifier();
        $identifier->setResolver($resolver)->setPasswordHasher($hasher);

        $result = $identifier->identify([]);

        static::assertNull($result);
    }

    /**
     * testIdentifyMultiField
     *
     * @return void
     */
    public function testIdentifyMultiField()
    {
        $resolver = $this->createMock(ResolverInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);

        $user = new ArrayObject([
            'username' => 'mariano',
            'email' => 'mariano@example.com',
            'password' => 'h45hedpa55w0rd',
        ]);

        $resolver->expects(static::once())
            ->method('find')
            ->with([
                'username' => 'mariano@example.com',
                'email' => 'mariano@example.com',
            ], 'OR')
            ->willReturn($user);

        $hasher->expects(static::once())
            ->method('check')
            ->with('password', 'h45hedpa55w0rd')
            ->willReturn(true);

        $hasher->expects(static::once())
            ->method('needsRehash')
            ->with('h45hedpa55w0rd');

        $identifier = new CognitoIdentifier([
            'fields' => ['username' => ['email', 'username']],
        ]);
        $identifier->setResolver($resolver)->setPasswordHasher($hasher);

        $result = $identifier->identify([
            'username' => 'mariano@example.com',
            'password' => 'password',
        ]);

        static::assertInstanceOf('\ArrayAccess', $result);
        static::assertSame($user, $result);
    }

    /**
     * testDefaultPasswordHasher
     *
     * @return void
     */
    public function testDefaultPasswordHasher()
    {
        $identifier = new CognitoIdentifier();
        $hasher = $identifier->getPasswordHasher();
        static::assertInstanceOf(DefaultPasswordHasher::class, $hasher);
    }
}
