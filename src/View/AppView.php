<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use BootstrapUI\View\UIViewTrait;
use Cake\Core\Configure;
use Cake\View\View;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @property \App\View\Helper\FunctionalHelper $Functional
 * @property \App\View\Helper\IconHelper $Icon
 * @property \App\View\Helper\InflectionHelper $Inflection
 *
 * @property \BootstrapUI\View\Helper\BreadcrumbsHelper $Breadcrumbs
 * @property \BootstrapUI\View\Helper\FormHelper $Form
 * @property \BootstrapUI\View\Helper\HtmlHelper $Html
 * @property \BootstrapUI\View\Helper\PaginatorHelper $Paginator
 *
 * @property \Authentication\View\Helper\IdentityHelper $Identity
 *
 * @link https://book.cakephp.org/3.0/en/views.html#the-app-view
 * @property \Tools\View\Helper\TimeHelper $Time
 * @property \Tools\View\Helper\FormatHelper $Format
 * @property \Flash\View\Helper\FlashHelper $Flash
 */
class AppView extends View
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadHelper('Html', ['className' => 'BootstrapUI.Html']);
        $this->loadHelper('Form', ['className' => 'BootstrapUI.Form']);
        $this->loadHelper('Paginator', ['className' => 'BootstrapUI.Paginator', 'templates' => 'paginator_templates']);

        if (class_exists('\Cake\View\Helper\BreadcrumbsHelper')) {
            $this->loadHelper('Breadcrumbs', ['className' => 'BootstrapUI.Breadcrumbs']);
        }

        $this->loadHelper('Time', ['className' => 'Tools.Time']);
        $this->loadHelper('Format', ['className' => 'Tools.Format']);

        $this->loadHelper('Flash.Flash');
        $this->loadHelper('Inflection');
        $this->loadHelper('Icon');

        $this->loadHelper('Authentication.Identity');

        $this->loadHelper('Functional');
    }
}
