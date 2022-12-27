<?php

declare(strict_types=1);

namespace App\Test\TestCase\Utility;

use App\Utility\Cartesian;
use Cake\TestSuite\TestCase;

/**
 * Class TextSafeTest
 *
 * @package App\Test\TestCase\Utility
 */
class CartesianTest extends TestCase
{
    /**
     * @return array
     */
    public function providerCartesianData()
    {
        return [
            'Two Arrays' => [
                [
                    'Location' => ['Calgary', 'Vancouver'],
                    'Person' => ['Jacob', 'Paul'],
                ],
                [
                    ['Calgary', 'Jacob'],
                    ['Calgary', 'Paul'],
                    ['Vancouver', 'Jacob'],
                    ['Vancouver', 'Paul'],
                ],
            ],
            'Three Arrays' => [
                [
                    'Location' => ['Calgary', 'Vancouver'],
                    'Person' => ['Jacob', 'Paul'],
                    'Car' => ['Jeep', 'Jaguar'],
                ],
                [
                    ['Calgary', 'Jacob', 'Jeep'],
                    ['Calgary', 'Jacob', 'Jaguar'],
                    ['Calgary', 'Paul', 'Jeep'],
                    ['Calgary', 'Paul', 'Jaguar'],
                    ['Vancouver', 'Jacob', 'Jeep'],
                    ['Vancouver', 'Jacob', 'Jaguar'],
                    ['Vancouver', 'Paul', 'Jeep'],
                    ['Vancouver', 'Paul', 'Jaguar'],
                ],
            ],
        ];
    }

    /**
     * Test encode()
     *
     * @param array[] $inputArray Input Array
     * @param array[] $expected Output Array
     * @return void
     * @dataProvider providerCartesianData
     */
    public function testBuild(array $inputArray, array $expected)
    {
        TestCase::assertEquals($expected, Cartesian::build($inputArray));
    }
}
