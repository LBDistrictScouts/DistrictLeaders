<?php
/**
 * @var \App\View\AppView $this
 * @var integer $loggedInUserId
 */

$path = $this->getRequest()->getPath();

$directory = false;
$documents = false;
$groups = false;

if (preg_match('(documents)', $path)) {
    $documents = true;
}

if (preg_match('(users)', $path)) {
    $directory = true;
}

if (preg_match('(groups|sections)', $path)) {
    $groups = true;
}

$active = $directory || $documents || $groups;
$this->set('moduleBar', $active);

if ($documents) : echo $this->element('ModuleNav/documents'); endif;

if ($directory) : echo $this->element('ModuleNav/directory'); endif;

if ($groups) : echo $this->element('ModuleNav/groups'); endif;
