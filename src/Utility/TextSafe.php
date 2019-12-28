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
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @since         2.2.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Utility;

/**
 * Library of Text Encoding Functions
 */
class TextSafe
{
    protected static $changeChars = [
        '=' => '~',
        '+' => '-',
        '/' => '_',
    ];

    /**
     * @param string $string The String to be Encoded
     *
     * @return string|string[]|null
     */
    public static function encode($string)
    {
        $changeChars = static::$changeChars;
        $pattern = [];

        foreach (array_keys($changeChars) as $idx => $item) {
            if ($item == '/') {
                $item = '\/';
            }
            $item = '/[' . $item . ']/';
            $pattern[$idx] = $item;
        }

        $replacement = array_values($changeChars);

        return preg_replace($pattern, $replacement, $string);
    }

    /**
     * @param string $string The String to be Decoded
     *
     * @return string|string[]|null
     */
    public static function decode($string)
    {
        $changeChars = static::$changeChars;
        $pattern = [];

        foreach (array_values($changeChars) as $idx => $item) {
            $item = '/[' . $item . ']/';
            $pattern[$idx] = $item;
        }

        $replacement = array_keys($changeChars);

        return preg_replace($pattern, $replacement, $string);
    }

    /**
     * @param int $length The length of the String
     *
     * @return string
     */
    public static function shuffle($length = 3)
    {
        $repeats = $length * 2;

        return substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVWXYZ", $repeats)), 0, $length);
    }
}
