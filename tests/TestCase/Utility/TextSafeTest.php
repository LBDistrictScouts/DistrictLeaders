<?php
declare(strict_types=1);

namespace App\Test\TestCase\Utility;

use App\Utility\TextSafe;
use Cake\TestSuite\TestCase;

/**
 * Class TextSafeTest
 *
 * @package App\Test\TestCase\Utility
 */
class TextSafeTest extends TestCase
{
    /**
     * @return array
     */
    public function providerEncodeData()
    {
        return [
            ['Jacob=Llama+Goat/Fish', 'Jacob~Llama-Goat_Fish'],
            ['Octopus==Random/+Monkey/+Boat', 'Octopus~~Random_-Monkey_-Boat'],
        ];
    }

    /**
     * Test encode()
     *
     * @param string $string String to be encoded
     * @param string $expected String expected after encoding
     * @return void
     * @dataProvider providerEncodeData
     */
    public function testEncode($string, $expected)
    {
        TestCase::assertEquals($expected, TextSafe::encode($string));
    }

    /**
     * Test decode()
     *
     * @param string $expected String expected after encoding
     * @param string $string String to be encoded
     * @dataProvider providerEncodeData
     * @return void
     */
    public function testDecode($expected, $string)
    {
        TestCase::assertEquals($expected, TextSafe::decode($string));
    }

    /**
     * @return array
     */
    public function providerShuffleData()
    {
        return [
            [3],
            [20],
            [99],
            [40],
            [2],
        ];
    }

    /**
     * Test decode()
     *
     * @param int $expected The length of the expected string
     * @dataProvider providerShuffleData
     * @return void
     */
    public function testShuffle($expected)
    {
        TestCase::assertEquals($expected, strlen(TextSafe::shuffle($expected)));
    }

    /**
     * @return array
     */
    public function providerProperName()
    {
        return [
            'Camel Cased' => [
                'JacobTyler',
                'Jacobtyler',
            ],
            'Hyphenated Name' => [
                'Lucy-May',
                'Lucy-May',
            ],
            'Upper Hyphenated Name' => [
                'LUCY-MAY',
                'Lucy-May',
            ],
            'Lower Hyphenated Name' => [
                'lucy-may',
                'Lucy-May',
            ],
            'Apostrophe Name' => [
                'D\'Arcy',
                'D\'Arcy',
            ],
            'Upper Apostrophe Name' => [
                'D\'ARCY',
                'D\'Arcy',
            ],
            'Lower Apostrophe Name' => [
                'd\'arcy',
                'D\'Arcy',
            ],
            'Hyphenated Name Two Names' => [
                'Lucy-May Gillian',
                'Lucy-May Gillian',
            ],
            'Upper Hyphenated Two Names' => [
                'LUCY-MAY GILLIAN',
                'Lucy-May Gillian',
            ],
            'Lower Hyphenated Two Names' => [
                'lucy-may gillian',
                'Lucy-May Gillian',
            ],
        ];
    }

    /**
     * Test decode()
     *
     * @param string $input The Wrong Cased Input Name
     * @param string $expected The length of the expected string
     * @return void
     * @dataProvider providerProperName
     */
    public function testProperName(string $input, string $expected)
    {
        TestCase::assertEquals($expected, TextSafe::properName($input));
    }
}
