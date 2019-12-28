<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;

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
     * Configuration Value
     *
     * @var array
     */
    public $FunctionalAreas;

    /**
     * Configuration Value
     *
     * @var array
     */
    public $SearchConfigured;

    /**
     * @param array $config The Config Array
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->FunctionalAreas = Configure::read('functionalAreas');
        $this->SearchConfigured = Configure::read('searchConfigured');
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
        if (key_exists($function, $this->FunctionalAreas)) {
            return (bool)$this->FunctionalAreas[$function]['enabled'];
        }

        return false;
    }

    /**
     * Set Functional Areas Values
     *
     * @param string $function The Function to be Checked
     * @param \App\Model\Entity\User $identity The User Identity
     * @param string|null $action The action being checked
     *
     * @return bool
     */
    public function checkFunctionAuth($function, $identity, $action = 'index')
    {
        $area = $this->checkFunction($function);

        $methodAuth = $this->FunctionalAreas[$function]['capability'][$action];
        $can = $identity->checkCapability($methodAuth);

        return (bool)($can && $area);
    }

    /**
     * Set Functional Areas Values
     *
     * @param string $searchModel The Function to be Checked
     *
     * @return bool
     */
    public function checkSearchConfigured($searchModel)
    {
        if (key_exists($searchModel, $this->SearchConfigured)) {
            return (bool)$this->SearchConfigured[$searchModel];
        }

        return false;
    }
}
