<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;

/**
 * Class IconHelper
 *
 * @package App\View\Helper
 */
class IconHelper extends Helper
{
    protected array $_defaultConfig = [
        'iconWeight' => 'fal',
        'iconPrefix' => 'fa',
    ];

    /**
     * @param string $iconName The name of the Icon
     * @param array|null $modifiers An Array of Additional Modifiers
     * @return string
     */
    private function buildIconString(string $iconName, ?array $modifiers = null): string
    {
        $weight = $this->getConfig('iconWeight');
        $prefix = $this->getConfig('iconPrefix');

        if (!str_contains($iconName, $prefix)) {
            $iconName = $prefix . '-' . $iconName;
        }

        $modifierString = '';

        if (!is_null($modifiers)) {
            foreach ($modifiers as $modifier) {
                $modifierString .= ' ' . $modifier;
            }
        }

        return $weight . ' ' . $iconName . $modifierString;
    }

    /**
     * @param string $iconString Output from BuildIconString
     * @return string
     */
    private function buildHtmlString(string $iconString): string
    {
        return '<i class="' . $iconString . '"></i>';
    }

    /**
     * @param string $entityName The Name of the Entity
     * @return string|false
     */
    private function getEntityIcon(string $entityName): string|false
    {
        Configure::load('Application' . DS . 'icon_standards', 'yaml', false);
        $iconStandard = Configure::read('IconStandards');

        if (key_exists($entityName, $iconStandard)) {
            return (string)$iconStandard[$entityName];
        }

        return false;
    }

    /**
     * @param string $iconName The name of the Icon
     * @param array|null $modifiers An Array of Additional Modifiers
     * @return string
     */
    public function iconStandard(string $iconName, ?array $modifiers = null): string
    {
        return $this->buildIconString($iconName, $modifiers);
    }

    /**
     * @param bool|null $booleanAttribute The Boolean Attribute
     * @return string
     */
    public function iconBoolean(?bool $booleanAttribute): string
    {
        if ($booleanAttribute) {
            return $this->iconCheck($booleanAttribute);
        }

        return $this->iconHtml('times');
    }

    /**
     * @param int $enhancedAttribute The Integer Boolean Representation
     * @return string
     */
    public function iconEnhancedBoolean(int $enhancedAttribute): string
    {
        if ($enhancedAttribute >= 2) {
            return $this->iconHtml('check-circle');
        }

        if ($enhancedAttribute == 1) {
            return $this->iconCheck(true);
        }

        return $this->iconHtml('times');
    }

    /**
     * Provides an HTML Icon Check String
     *
     * @param bool|null $booleanAttribute The Boolean Attribute
     * @return string
     */
    public function iconCheck(?bool $booleanAttribute): string
    {
        if ($booleanAttribute) {
            return $this->iconHtml('check');
        }

        return '';
    }

    /**
     * @param string $iconName The name of the Icon
     * @param array|null $modifiers An Array of Additional Modifiers
     * @return string
     */
    public function iconHtml(string $iconName, ?array $modifiers = null): string
    {
        $iconString = $this->buildIconString($iconName, $modifiers);

        return $this->buildHtmlString($iconString);
    }

    /**
     * @param string $entityName The name of the Icon
     * @param array|null $modifiers An Array of Additional Modifiers
     * @return string|bool
     */
    public function iconStandardEntity(string $entityName, ?array $modifiers = null): string|bool
    {
        $iconName = $this->getEntityIcon($entityName);
        if (!$iconName) {
            return false;
        }

        return $this->buildIconString($iconName, $modifiers);
    }

    /**
     * @param string $entityName The name of the Icon
     * @param array|null $modifiers An Array of Additional Modifiers
     * @return string|bool
     */
    public function iconHtmlEntity(string $entityName, ?array $modifiers = null): string|bool
    {
        $iconName = $this->getEntityIcon($entityName);
        if ($iconName == false) {
            return false;
        }

        $iconString = $this->buildIconString($iconName, $modifiers);

        return $this->buildHtmlString($iconString);
    }
}
