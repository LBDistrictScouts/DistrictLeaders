<?php
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
     * Test encode()
     *
     * @return void
     */
    public function testEncode()
    {
        $string = 'Jacob=Llama+Goat/Fish';
        $expected = 'Jacob~Llama-Goat_Fish';

        $this->assertEquals($expected, TextSafe::encode($string));
    }

    /**
     * Test decode()
     *
     * @return void
     */
    public function testDecode()
    {
        $expected = 'Jacob=Llama+Goat/Fish';
        $string = 'Jacob~Llama-Goat_Fish';

        $this->assertEquals($expected, TextSafe::decode($string));
    }

    /**
     * Test decode()
     *
     * @return void
     */
    public function testShuffle()
    {
        $expected = 3;

        $this->assertEquals($expected, strlen(TextSafe::shuffle($expected)));

        $expected = 20;

        $this->assertEquals($expected, strlen(TextSafe::shuffle($expected)));
    }
}
