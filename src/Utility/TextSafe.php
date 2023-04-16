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
    protected static array $changeChars = [
        '=' => '~',
        '+' => '-',
        '/' => '_',
    ];

    /**
     * @param string $string The String to be Encoded
     * @return array<string>|string|null
     */
    public static function encode(string $string): string|array|null
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
     * @return array<string>|string|null
     */
    public static function decode(string $string): string|array|null
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
     * @return string
     */
    public static function shuffle(int $length = 3): string
    {
        $repeats = $length * 2;

        return substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ', $repeats)), 0, $length);
    }

    /**
     * @param string $name The Name to be Proper Cased
     * @return string
     */
    public static function properName(string $name): string
    {
        $name = strtolower($name);
        $name = ucwords($name);

        // Hold Space as Special Char
        $spacePattern = '[ ]';
        if (preg_match($spacePattern, $name)) {
            $name = preg_replace($spacePattern, '#', $name);
        }

        $otherSeparators = [
            'Apostrophe' => '\'',
            'Hyphen' => '-',
        ];

        foreach ($otherSeparators as $separator) {
            $separatorPattern = '[' . $separator . ']';
            if (preg_match($separatorPattern, $name)) {
                $name = preg_replace($separatorPattern, ' ', $name);
                $name = ucwords($name);
                $name = preg_replace($spacePattern, $separator, $name);
            }
        }

        // Reverse Space Hold
        if (preg_match('[#]', $name)) {
            $name = preg_replace('[#]', ' ', $name);
        }

        return $name;
    }
}
