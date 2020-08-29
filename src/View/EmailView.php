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

use Cake\View\View;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @property \App\View\Helper\FunctionalHelper $Functional
 * @property \App\View\Helper\JobHelper $Job
 * @property \App\View\Helper\IconHelper $Icon
 * @property \App\View\Helper\InflectionHelper $Inflection
 * @property \App\View\Helper\CapIdentityHelper $Identity
 * @property \App\View\Helper\MarkdownHelper $Markdown
 *
 * @property \BootstrapUI\View\Helper\BreadcrumbsHelper $Breadcrumbs
 * @property \BootstrapUI\View\Helper\FormHelper $Form
 * @property \BootstrapUI\View\Helper\HtmlHelper $Html
 * @property \BootstrapUI\View\Helper\PaginatorHelper $Paginator
 * @link https://book.cakephp.org/3.0/en/views.html#the-app-view
 * @property \Tools\View\Helper\TimeHelper $Time
 * @property \Tools\View\Helper\FormatHelper $Format
 * @property \Flash\View\Helper\FlashHelper $Flash
 * @property \Search\View\Helper\SearchHelper $Search
 * @property \Queue\View\Helper\QueueProgressHelper $QueueProgress
 * @property \App\View\Helper\CapIdentityHelper $CapIdentity
 */
class EmailView extends View
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
        $this->loadHelper('Time', ['className' => 'Tools.Time']);
        $this->loadHelper('Text');
    }

    /**
     * Renders view for given template file and layout.
     *
     * Render triggers helper callbacks, which are fired before and after the template are rendered,
     * as well as before and after the layout. The helper callbacks are called:
     *
     * - `beforeRender`
     * - `afterRender`
     * - `beforeLayout`
     * - `afterLayout`
     *
     * If View::$autoLayout is set to `false`, the template will be returned bare.
     *
     * Template and layout names can point to plugin templates or layouts. Using the `Plugin.template` syntax
     * a plugin template/layout/ can be used instead of the app ones. If the chosen plugin is not found
     * the template will be located along the regular view path cascade.
     *
     * @param string|null $template Name of template file to use
     * @param string|false|null $layout Layout to use. False to disable.
     * @return string Rendered content.
     * @throws \Cake\Core\Exception\Exception If there is an error in the view.
     * @triggers View.beforeRender $this, [$templateFileName]
     * @triggers View.afterRender $this, [$templateFileName]
     */
    public function render(?string $template = null, $layout = null): string
    {
        $content = parent::render($template, $layout);

        if (!isset($this->InlineCss)) {
            $this->InlineCss = new CssToInlineStyles();
        }

        // Convert inline style blocks to inline CSS on the HTML content.
        return $this->InlineCss->convert($content);
    }
}
