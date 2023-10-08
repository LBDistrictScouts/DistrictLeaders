<?php
declare(strict_types=1);

namespace App\Utility;

/**
 * Class Cartesian
 */
class Cartesian
{
    /**
     * @param array<array> $set Multiple Arrays to be Cartesian Joined
     * @return array<array>
     */
    public static function build(array $set): array
    {
        if (!$set) {
            return [[]];
        }

        $subset = array_shift($set);
        $cartesianSubset = self::build($set);

        $result = [];
        foreach ($subset as $value) {
            foreach ($cartesianSubset as $p) {
                array_unshift($p, $value);
                $result[] = $p;
            }
        }

        return $result;
    }
}
