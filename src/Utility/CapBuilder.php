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

use App\Model\Entity\Capability;
use Cake\Core\Configure;
use Cake\Utility\Inflector;

/**
 * Library of Text Encoding Functions
 */
class CapBuilder
{
    /**
     * @var string
     */
    protected static $fieldPrefix = 'FIELD';

    /**
     * @var int
     */
    protected static $maxLevel = 5;

    /**
     * @var int
     */
    protected static $minLevel = 1;

    /**
     * @var int
     */
    protected static $absoluteMinLevel = 0;

    protected static $actionOverrides = [
      'INDEX' => 'VIEW',
      'ADD' => 'CREATE',
      'EDIT' => 'UPDATE',
      'SEARCH' => 'VIEW',
      'PERMISSIONS' => 'VIEW',
    ];

    protected static $fieldActionOverrides = [
        'CHANGE' => 'UPDATE',
    ];

    protected static $fieldCapabilities = [
        'CHANGE' => 1,
        'VIEW' => 0,
    ];

    protected static $entityCapabilities = [
        'CREATE' => 1,
        'UPDATE' => 1,
        'VIEW' => -5,
        'DELETE' => 5,
    ];

    /**
     * @param string $action The name of the Action performed
     * @param string $model The Model to be formatted
     * @param string|null $field The Field being limited
     * @return string|false
     */
    public static function capabilityCodeFormat(string $action, string $model, ?string $field = null)
    {
        $action = CapBuilder::applyActionOverrides($action);

        if (!is_null($field) && self::isFieldRestricted($model)) {
            if (!CapBuilder::isFieldActionType($action)) {
                return false;
            }
            $code = ucwords(strtolower(static::$fieldPrefix)) . ucfirst(strtolower($action)) . $model;
        } else {
            $action = CapBuilder::applyFieldActionOverrides($action);

            if (!CapBuilder::isEntityActionType($action)) {
                return false;
            }
            $code = ucfirst(strtolower($action)) . $model;
        }

        $code = Inflector::underscore(Inflector::singularize($code));

        if (!is_null($field) && self::isFieldRestricted($model)) {
            $code .= '@' . $field;
        }

        return strtoupper($code);
    }

    /**
     * @param string $action The name of the Action performed
     * @param string $model The Model to be formatted
     * @param string|null $field The Field Restriction
     * @return string|false
     */
    public static function capabilityNameFormat(string $action, string $model, ?string $field = null)
    {
        if (
            (!is_null($field) && !CapBuilder::isFieldActionType($action))
            || (is_null($field) && !CapBuilder::isEntityActionType($action))
        ) {
            return false;
        }

        $action = ucwords(strtolower($action));
        $model = Inflector::singularize(Inflector::humanize(Inflector::underscore($model)));

        if (!is_null($field)) {
            $name = $action . ' field';
            $name .= ' "' . Inflector::humanize($field) . '" on';
        } else {
            $name = $action;
        }

        return $name . ' a ' . $model;
    }

    /**
     * @param int $baseLevel The Base Level for Capability
     * @param int $multiplier The Action Multiplier
     * @param bool|null $viewRestricted Is the view action restricted
     * @return int
     */
    public static function calculateLevel(int $baseLevel, int $multiplier, ?bool $viewRestricted = false): int
    {
        if ($multiplier == -static::$maxLevel && $viewRestricted) {
            $multiplier = 0;
        }
        $level = $baseLevel + $multiplier;

        $minLevel = static::$minLevel;
        if ($baseLevel == 0) {
            $minLevel = static::$absoluteMinLevel;
        }
        $level = max($minLevel, $level);

        return min(static::$maxLevel, $level);
    }

    /**
     * @return array
     */
    protected static function actionTypes(): array
    {
        return array_merge(
            CapBuilder::fieldActionTypes(),
            CapBuilder::entityActionTypes()
        );
    }

    /**
     * @param string $action Action which might need overriding
     * @return string
     */
    protected static function applyActionOverrides(string $action): string
    {
        $action = strtoupper($action);

        if (key_exists($action, self::$actionOverrides)) {
            return self::$actionOverrides[$action];
        }

        return $action;
    }

    /**
     * @param string $action Action which might need overriding
     * @return string
     */
    protected static function applyFieldActionOverrides(string $action): string
    {
        $action = strtoupper($action);

        if (key_exists($action, self::$fieldActionOverrides)) {
            return self::$fieldActionOverrides[$action];
        }

        return $action;
    }

    /**
     * @return array
     */
    protected static function entityActionTypes(): array
    {
        return array_keys(self::getEntityCapabilities());
    }

    /**
     * @return array
     */
    public static function getEntityCapabilities(): array
    {
        return self::$entityCapabilities;
    }

    /**
     * @return array
     */
    protected static function fieldActionTypes(): array
    {
        return array_keys(self::getFieldCapabilities());
    }

    /**
     * @return array
     */
    public static function getFieldCapabilities(): array
    {
        return self::$fieldCapabilities;
    }

    /**
     * @return array
     */
    protected static function fieldModels(): array
    {
        $array = [];

        foreach (Configure::read('AllModels') as $model => $options) {
            if ($options['fieldLock']) {
                array_push($array, $model);
            }
        }

        return $array;
    }

    /**
     * @param string $action Action to be Checked
     * @return bool
     */
    public static function isFieldActionType(string $action): bool
    {
        $action = self::applyActionOverrides($action);

        return (bool)in_array($action, CapBuilder::fieldActionTypes());
    }

    /**
     * @param string $action Action to be Checked
     * @return bool
     */
    public static function isEntityActionType(string $action): bool
    {
        $action = self::applyActionOverrides($action);

        return (bool)in_array($action, CapBuilder::entityActionTypes());
    }

    /**
     * @param string $capability Capability to be Checked
     * @return bool
     */
    public static function isFieldType(string $capability): bool
    {
        if (is_null($capability)) {
            return false;
        }

        return (bool)(substr($capability, 0, 5) == strtoupper(static::$fieldPrefix));
    }

    /**
     * @param string $action The Action to be validated
     * @return bool
     */
    public static function isActionType(string $action): bool
    {
        $action = CapBuilder::applyActionOverrides($action);

        return (bool)in_array($action, CapBuilder::actionTypes());
    }

    /**
     * @param string $model The Model to be validated
     * @return bool
     */
    public static function isFieldRestricted(string $model): bool
    {
        return (bool)in_array($model, CapBuilder::fieldModels());
    }

    /**
     * @param string $capabilityCode Capability code to be broken
     * @return array|false
     */
    protected static function breakFieldCode(string $capabilityCode)
    {
        if (CapBuilder::isFieldType($capabilityCode)) {
            $code = substr($capabilityCode, 6);

            return explode('@', $code);
        }

        return false;
    }

    /**
     * @param string $capabilityCode The Capability Code to be broken
     * @return array
     */
    public static function breakSpecialCode(string $capabilityCode): array
    {
        $outArray = [
            'is_special' => false,
            'is_field' => false,
            'field' => null,
            'crud' => null,
            'model' => null,
            'type' => null,
        ];

        if (CapBuilder::isSpecialCode($capabilityCode)) {
            $outArray['is_special'] = true;
        } else {
            $brokenArray = CapBuilder::breakCode($capabilityCode);
            if (is_array($brokenArray)) {
                $outArray = array_merge($outArray, $brokenArray);
            }
        }

        if ($outArray['is_special']) {
            $outArray['type'] = 'Special';
        } elseif ($outArray['is_field']) {
            $outArray['type'] = 'Field';
        } elseif (!is_null($outArray['model'])) {
            $outArray['type'] = 'Entity';
        }

        return $outArray;
    }

    /**
     * @param string $capabilityCode The Capability Code to be broken
     * @return array|false
     */
    public static function breakCode(string $capabilityCode)
    {
        $code = $capabilityCode;
        if (CapBuilder::isFieldType($capabilityCode)) {
            $fieldBreak = CapBuilder::breakFieldCode($capabilityCode);
            $outArray['field'] = $fieldBreak[1];
            $code = $fieldBreak[0];
        }

        $codeArray = explode('_', $code, 2);
        if (count($codeArray) < 2) {
            return false;
        }
        $outArray['crud'] = $codeArray[0];
        $outArray['model'] = Inflector::pluralize(Inflector::camelize(strtolower($codeArray[1])));
        $outArray['is_field'] = (bool)CapBuilder::isFieldType($capabilityCode);

        return $outArray;
    }

    /**
     * @param string $capabilityCode Capability Code for testing
     * @return bool
     */
    public static function isSpecialCode(string $capabilityCode): bool
    {
        if (is_null($capabilityCode)) {
            return false;
        }

        foreach (Configure::read('BaseCapabilities') as $cap) {
            if ($capabilityCode == $cap[Capability::FIELD_CAPABILITY_CODE]) {
                return true;
            }
        }

        return false;
    }
}
