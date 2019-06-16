<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

class FunctionalHelper extends Helper
{
    protected $_defaultConfig = [
        'functionalAreas' => [
            'directory' => true,
            'camps' => true,
            'documents' => true,
            'articles' => true,
            'search' => true,
        ],
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
     * Set Functional Areas Values
     *
     * @param string $function The Function to be Checked
     *
     * @return bool
     */
    public function checkFunction($function)
    {
        $areas = $this->getConfig('functionalAreas');

        if (key_exists($function, $areas)) {
            return (bool)$areas[$function];
        }

        return false;
    }
}