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

use Cake\Core\Configure;
use Cake\Utility\Inflector;

/**
 * Library of Text Encoding Functions
 */
class GroupParser
{
    /**
     * @param string $group The Group to be Aliased
     * @return string
     */
    public static function aliasGroup(string $group): string
    {
        return trim(preg_replace('/( [(]?St.[A-Za-z \']+[)]?)/', '', $group));
    }

    /**
     * @param string $section The Section to be Parsed
     * @param string $group The Aliased Group for Context
     * @return string
     */
    public static function parseSection(string $section, string $group): string
    {
        // Remove Trailing Numbers
        $section = trim(preg_replace('/( [0-9]+)/', '', $section));

        // Cub Scout to Cubs
        if (preg_match('/(Cub|Beaver|Explorer)( Scout)/', $section)) {
            $section = Inflector::pluralize(trim(preg_replace('/( Scout)/', '', $section)));
        } else {
            $section = preg_replace('/( Scout(?!s))/', ' Scouts', $section);
        }

        if (self::aliasGroup($section) == $group) {
            return self::aliasGroup($section);
        }

        // Renamed Sections (standard)
        $section = trim(preg_replace('/([0-9]+(rd|st|th) (Letchworth|Baldock|Ashwell))/', '', $section));

        // Active Support
        $section = trim(preg_replace('/(Active Support Unit)/', 'Scout Active Support', $section));

        if (preg_match('/(Cub|Beaver|Explorer|Scout)[s]?( Section)/', $section)) {
            $section = Inflector::pluralize(trim(preg_replace('/(Section)/', '', $section)));
        }

        return $section;
    }

    /**
     * Performs Entity & Specific Section Mapping
     *
     * @param string $section Section for Type Aliasing
     * @return string
     */
    public static function aliasSectionType(string $section): string
    {
        Configure::load('Application' . DS . 'section_map', 'yaml', false);

        $entityMap = Configure::read('SectionEntityMap', []);
        $specificMap = Configure::read('SectionSpecificMap', []);
        $map = array_merge($entityMap, $specificMap);

        if (key_exists($section, $map)) {
            return $map[$section];
        }

        $section = trim(preg_replace(
            '/[A-Za-z ()]*( )?(Scout Network)/', // ASU Replacement
            'Scout Network',
            $section
        ));
        $section = trim(preg_replace(
            '/[A-Za-z ()]*( )(ASU|Active Support)( Unit)?/', // ASU Replacement
            'Scout Active Support',
            $section
        ));

        return trim(preg_replace('/[A-Za-z ]*( Explorer)( Unit)?/', 'Explorers', $section));
    }

    /**
     * @param string $role Role to be Parsed
     * @param string|null $sectionType Section Type Context
     * @return string
     */
    public static function parseRole(string $role, ?string $sectionType = null): string
    {
        if (preg_match('/( - )/', $role)) {
            $roles = explode(' - ', $role, 2);
            [$role, $sectionType] = $roles;
        }
        $sectionType = Inflector::pluralize($sectionType);

        // Remove Provisional
        $role = preg_replace('/[(](Pre-)*(Prov)[)]/', '', $role);

        // Brackets for ADC
        $role = preg_replace('/[(](Section)[)]/', '(' . $sectionType . ')', $role);

        $sectionType = Inflector::singularize($sectionType);
        if (!preg_match('/(Scout)/', $sectionType)) {
            $sectionType = $sectionType . ' Scout';
        }
        $role = preg_replace('/(Section)(?! Assistant)/', $sectionType, $role);
        $role = preg_replace('/(Section Assistant)/', $sectionType . ' Section Assistant', $role);

        return trim($role);
    }
}
