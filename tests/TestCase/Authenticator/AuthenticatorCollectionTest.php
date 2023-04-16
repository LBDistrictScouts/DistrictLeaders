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

namespace App\Test\TestCase\Authenticator;

use Authentication\Authenticator\AuthenticatorCollection;
use Authentication\Authenticator\AuthenticatorInterface;
use Authentication\Authenticator\FormAuthenticator;
use Authentication\Identifier\IdentifierCollection;
use Cake\TestSuite\TestCase;

/**
 * Class AuthenticatorCollectionTest
 *
 * @package App\Test\TestCase\Authenticator
 */
class AuthenticatorCollectionTest extends TestCase
{
    /**
     * Test constructor.
     *
     * @return void
     */
    public function testConstruct()
    {
        $identifiers = $this->createMock(IdentifierCollection::class);
        $collection = new AuthenticatorCollection($identifiers, [
            'Authentication.Form',
        ]);
        $result = $collection->get('Form');
        static::assertInstanceOf(FormAuthenticator::class, $result);
    }

    /**
     * testLoad
     *
     * @return void
     * @throws Exception
     */
    public function testLoad()
    {
        $identifiers = $this->createMock(IdentifierCollection::class);
        $collection = new AuthenticatorCollection($identifiers);
        $result = $collection->load('Authentication.Form');
        static::assertInstanceOf(FormAuthenticator::class, $result);
    }

    /**
     * testSet
     *
     * @return void
     */
    public function testSet()
    {
        $identifiers = $this->createMock(IdentifierCollection::class);
        $authenticator = $this->createMock(AuthenticatorInterface::class);

        $collection = new AuthenticatorCollection($identifiers);
        $collection->set('Form', $authenticator);
        static::assertSame($authenticator, $collection->get('Form'));
    }

    /**
     * testLoadException
     *
     * @return void
     * @throws Exception
     */
    public function testLoadException()
    {
        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('Authenticator class `Does-not-exist` was not found.');
        $identifiers = $this->createMock(IdentifierCollection::class);
        $collection = new AuthenticatorCollection($identifiers);
        $collection->load('Does-not-exist');
    }

    /**
     * testIsEmpty
     *
     * @return void
     * @throws Exception
     */
    public function testIsEmpty()
    {
        $identifiers = $this->createMock(IdentifierCollection::class);
        $collection = new AuthenticatorCollection($identifiers);
        static::assertTrue($collection->isEmpty());

        $collection->load('Authentication.Form');
        static::assertFalse($collection->isEmpty());
    }

    /**
     * testIterator
     *
     * @return void
     */
    public function testIterator()
    {
        $identifiers = $this->createMock(IdentifierCollection::class);
        $authenticator = $this->createMock(AuthenticatorInterface::class);

        $collection = new AuthenticatorCollection($identifiers);
        $collection->set('Form', $authenticator);

        static::assertContains($authenticator, $collection);
    }
}
