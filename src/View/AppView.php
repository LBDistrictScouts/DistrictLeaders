<?php

declare(strict_types=1);

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

use App\View\Helper\CapIdentityHelper;
use App\View\Helper\FunctionalHelper;
use App\View\Helper\IconHelper;
use App\View\Helper\InflectionHelper;
use App\View\Helper\JobHelper;
use App\View\Helper\MarkdownHelper;
use App\View\Helper\PermissionsHelper;
use BootstrapUI\View\Helper\BreadcrumbsHelper;
use BootstrapUI\View\Helper\FormHelper;
use BootstrapUI\View\Helper\HtmlHelper;
use BootstrapUI\View\Helper\PaginatorHelper;
use Cake\View\View;
use Flash\View\Helper\FlashHelper;
use Queue\View\Helper\QueueProgressHelper;
use Search\View\Helper\SearchHelper;
use Tags\View\Helper\TagHelper;
use Tools\View\Helper\FormatHelper;
use Tools\View\Helper\TimeHelper;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link https://book.cakephp.org/3.0/en/views.html#the-app-view
 * @property FunctionalHelper $Functional
 * @property JobHelper $Job
 * @property IconHelper $Icon
 * @property InflectionHelper $Inflection
 * @property CapIdentityHelper $Identity
 * @property MarkdownHelper $Markdown
 *
 * @property BreadcrumbsHelper $Breadcrumbs
 * @property FormHelper $Form
 * @property HtmlHelper $Html
 * @property PaginatorHelper $Paginator
 * @property TimeHelper $Time
 * @property FormatHelper $Format
 * @property FlashHelper $Flash
 * @property SearchHelper $Search
 * @property QueueProgressHelper $QueueProgress
 * @property CapIdentityHelper $CapIdentity
 * @property PermissionsHelper $Permissions
 * @property TagHelper $Tag
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
    public function initialize(): void
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
        $this->loadHelper('Job');
        $this->loadHelper('Permissions');

        $this->loadHelper('Identity', ['className' => 'CapIdentity']);

        $this->loadHelper('Functional');
        $this->loadHelper('Queue.QueueProgress');
        $this->loadHelper('Search.Search');
        $this->loadHelper('Tags.Tag');
    }
}
