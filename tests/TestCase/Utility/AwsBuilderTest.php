<?php

declare(strict_types=1);

namespace App\Test\TestCase\Utility;

use App\Utility\AwsBuilder;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\Sdk;
use Cake\TestSuite\TestCase;

/**
 * Class TextSafeTest
 *
 * @package App\Test\TestCase\Utility
 */
class AwsBuilderTest extends TestCase
{
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test encode()
     *
     * @return void
     */
    public function testBuildCognitoClient()
    {
        $mockSdkClient = $this->getMockBuilder(Sdk::class)
            ->disableOriginalConstructor()
            ->addMethods(['createCognitoIdentityProvider'])
            ->getMock();

        $mockCognitoClient = $this->getMockBuilder(CognitoIdentityProviderClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockSdkClient->expects(TestCase::never())
            ->method('createCognitoIdentityProvider')
            ->willReturn($mockCognitoClient);

        TestCase::assertInstanceOf(CognitoIdentityProviderClient::class, AwsBuilder::buildCognitoClient());
    }
}
