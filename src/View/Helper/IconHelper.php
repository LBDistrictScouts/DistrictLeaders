<?php
namespace App\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\View\View;

class IconHelper extends Helper
{
    protected $_defaultConfig = [
        'iconWeight' => 'fal',
        'iconPrefix' => 'fa',
    ];

    /**
     * @param array $config The Config Array
     *
     * @return void
     */
    public function initialize(array $config)
    {
    }

    /**
     * @param string $iconName The name of the Icon
     * @param array|null $modifiers An Array of Additional Modifiers
     *
     * @return string
     */
    private function buildIconString($iconName, $modifiers = null)
    {
        $weight = $this->getConfig('iconWeight');
        $prefix = $this->getConfig('iconPrefix');

        $modifierString = '';

        foreach ($modifiers as $modifier) {
            $modifierString .= ' ' . $modifier;
        }

        return $weight . ' ' . $prefix . '-' . $iconName . $modifierString;
    }

    /**
     * @param string $iconString Output from BuildIconString
     *
     * @return string
     */
    private function buildHtmlString($iconString)
    {
        return '<i class="' . $iconString . '"></i>';
    }

    /**
     * @param string $entityName The Name of the Entity
     *
     * @return string|bool
     */
    private function getEntityIcon($entityName)
    {
        $iconStandard = Configure::read('iconStandards');

        if (key_exists($entityName, $iconStandard)) {
            return (string)$iconStandard[$entityName];
        }

        return false;
    }

    /**
     * @param string $iconName The name of the Icon
     * @param array|null $modifiers An Array of Additional Modifiers
     *
     * @return string
     */
    public function iconStandard($iconName, $modifiers = null)
    {
        return $this->buildIconString($iconName, $modifiers);
    }

    /**
     * @param string $iconName The name of the Icon
     * @param array|null $modifiers An Array of Additional Modifiers
     *
     * @return string
     */
    public function iconHtml($iconName, $modifiers = null)
    {
        $iconString = $this->buildIconString($iconName, $modifiers);

        return $this->buildHtmlString($iconString);
    }

    /**
     * @param string $entityName The name of the Icon
     * @param array|null $modifiers An Array of Additional Modifiers
     *
     * @return string|bool
     */
    public function iconStandardEntity($entityName, $modifiers = null)
    {
        $iconName = $this->getEntityIcon($entityName);
        if ($iconName == false) {
            return false;
        }

        return $this->buildIconString($iconName, $modifiers);
    }

    /**
     * @param string $entityName The name of the Icon
     * @param array|null $modifiers An Array of Additional Modifiers
     *
     * @return string|bool
     */
    public function iconHtmlEntity($entityName, $modifiers = null)
    {
        $iconName = $this->getEntityIcon($entityName);
        if ($iconName == false) {
            return false;
        }

        $iconString = $this->buildIconString($iconName, $modifiers);

        return $this->buildHtmlString($iconString);
    }
}
