<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View\Helper;

use Authentication\View\Helper\IdentityHelper;

/**
 * Identity Helper
 *
 * A convenience helper to access the identity data
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class CapIdentityHelper extends IdentityHelper
{
    /**
     * Identity Object
     *
     * @var null|\Authentication\IdentityInterface|\App\Model\Entity\User
     */
    protected $_identity;

    /**
     * @param string $capabilityCode Capability Code for Checking
     *
     * @return bool
     */
    public function checkCapability($capabilityCode)
    {
        return $this->_identity->checkCapability($capabilityCode);
    }

    /**
     * @param string $action The Action Method
     * @param string $model The Model being Referenced
     * @param int|null $group The Group ID for checking against
     * @param int|null $section The Section ID for checking against
     * @param string|null $field The field for action
     *
     * @return bool
     */
    public function buildAndCheckCapability($action, $model, $group = null, $section = null, $field = null)
    {
        return $this->_identity->buildAndCheckCapability($action, $model, $group, $section, $field);
    }
}
