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

use App\Authenticator\CognitoResult;
use Cake\ORM\Entity;
use Cake\TestSuite\TestCase;
use stdClass;

/**
 * Class CognitoResultTest
 *
 * @package Authentication\Test\TestCase\Authenticator
 */
class CognitoResultTest extends TestCase
{
    /**
     * testConstructorEmptyData
     *
     * @return void
     */
    public function testConstructorEmptyData()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Identity data can not be empty with status success.');
        new CognitoResult(null, CognitoResult::SUCCESS);
    }

    /**
     * testConstructorInvalidData
     *
     * @return void
     */
    public function testConstructorInvalidData()
    {
        $this->expectException('TypeError');
//        $this->expectExceptionMessage('App\Authenticator\CognitoResult::__construct(): Argument #1 ($data) must be of type ArrayAccess|array|null, `stdClass` given.');

        new CognitoResult(new stdClass(), CognitoResult::FAILURE_CREDENTIALS_INVALID);
    }

    /**
     * testIsValid
     *
     * @return void
     */
    public function testIsValid()
    {
        $result = new CognitoResult(null, CognitoResult::FAILURE_CREDENTIALS_INVALID);
        static::assertFalse($result->isValid());

        $result = new CognitoResult(null, CognitoResult::FAILURE_CREDENTIALS_MISSING);
        static::assertFalse($result->isValid());

        $result = new CognitoResult(null, CognitoResult::FAILURE_IDENTITY_NOT_FOUND);
        static::assertFalse($result->isValid());

        $result = new CognitoResult(null, CognitoResult::FAILURE_OTHER);
        static::assertFalse($result->isValid());

        $entity = new Entity(['user' => 'florian']);
        $result = new CognitoResult($entity, CognitoResult::SUCCESS);
        static::assertTrue($result->isValid());
    }

    /**
     * testGetIdentity
     *
     * @return void
     */
    public function testGetIdentity()
    {
        $entity = new Entity(['user' => 'florian']);
        $result = new CognitoResult($entity, CognitoResult::SUCCESS);
        static::assertEquals($entity, $result->getData());
    }

    /**
     * testGetIdentityArray
     *
     * @return void
     */
    public function testGetIdentityArray()
    {
        $data = ['user' => 'florian'];
        $result = new CognitoResult($data, CognitoResult::SUCCESS);
        static::assertEquals($data, $result->getData());
    }

    /**
     * testGetCode
     *
     * @return void
     */
    public function testGetCode()
    {
        $result = new CognitoResult(null, CognitoResult::FAILURE_IDENTITY_NOT_FOUND);
        static::assertEquals(CognitoResult::FAILURE_IDENTITY_NOT_FOUND, $result->getStatus());

        $entity = new Entity(['user' => 'florian']);
        $result = new CognitoResult($entity, CognitoResult::SUCCESS);
        static::assertEquals(CognitoResult::SUCCESS, $result->getStatus());
    }

    /**
     * testGetErrors
     *
     * @return void
     */
    public function testGetErrors()
    {
        $messages = [
            'Out of coffee!',
            'Out of beer!',
        ];
        $entity = new Entity(['user' => 'florian']);
        $result = new CognitoResult($entity, CognitoResult::FAILURE_OTHER, $messages);
        static::assertEquals($messages, $result->getErrors());
    }
}
