<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Model\Entity\User;
use Cake\Core\Configure;
use Cake\View\Helper;

/**
 * Class FunctionalHelper
 *
 * @package App\View\Helper
 */
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
    private $FunctionalAreas;

    /**
     * Configuration Value
     *
     * @var array
     */
    private $FunctionalArea;

    /**
     * Configuration Value
     *
     * @var array
     */
    private $SearchConfigured;

    /**
     * @param array $config The Config Array
     * @return void
     */
    public function initialize(array $config): void
    {
        Configure::load('Application' . DS . 'functional_areas', 'yaml', false);

        $this->FunctionalAreas = Configure::read('functionalAreas');
        $this->SearchConfigured = Configure::read('searchConfigured');
    }

    /**
     * @param string $function Functional Area Key
     * @return void
     */
    private function setFunctionalArea(string $function)
    {
        if (key_exists($function, $this->FunctionalAreas) && is_array($this->FunctionalAreas[$function])) {
            $this->FunctionalArea = $this->FunctionalAreas[$function];
        }
    }

    /**
     * Check if function is visible externally
     *
     * @return bool
     */
    private function checkFunctionExposed(): bool
    {
        return (bool)($this->FunctionalArea['exposed'] ?? false);
    }

    /**
     * Check if function is configured as active
     *
     * @param string|null $function The Functional Area
     * @return bool
     */
    public function checkFunctionEnabled(?string $function = null): bool
    {
        if (!is_null($function)) {
            $this->setFunctionalArea($function);
        }

        if (isset($this->FunctionalArea)) {
            return (bool)($this->FunctionalArea['enabled'] ?? false);
        }

        return false;
    }

    /**
     * @param string $function The functional area being checked
     * @param \App\Model\Entity\User $identity The User Identity
     * @param string $registeredCap The registered capability key
     * @return bool
     */
    private function checkFunctionAuthorised(string $function, User $identity, string $registeredCap)
    {
        // Check for Special Auth Registered on Function
        if (key_exists('capability', $this->FunctionalArea)) {
            $methodAuth = $this->FunctionalArea['capability'][$registeredCap];
            $special = $identity->checkCapability($methodAuth);

            if ($special) {
                return true;
            }
        }

        // Build standard authorisation configuration
        return $identity->buildAndCheckCapability('VIEW', $function);
    }

    /**
     * Set Functional Areas Values
     *
     * @param string $function The Function to be Checked
     * @param \App\Model\Entity\User|null $identity The User Identity
     * @param string|null $registeredCap The registered capability key
     * @return bool
     */
    public function checkFunction(string $function, ?User $identity = null, string $registeredCap = 'index'): bool
    {
        $this->setFunctionalArea($function);

        // Check if function is available externally
        $exposed = $this->checkFunctionExposed();

        // User not logged in (external) & function not exposed
        if (is_null($identity) && !$exposed) {
            return false;
        }

        $functionEnabled = $this->checkFunctionEnabled();
        $can = $exposed;

        if (!$exposed) {
            $can = $this->checkFunctionAuthorised($function, $identity, $registeredCap);
        }

        return (bool)($can && $functionEnabled);
    }

    /**
     * Set Functional Areas Values
     *
     * @param string $searchModel The Function to be Checked
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
