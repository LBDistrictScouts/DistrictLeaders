<?php
/**
 * @var \App\View\AppView $this
 * @var integer $loggedInUserId
 */

$path = $this->getRequest()->getPath();

$directory = false;
$documents = false;

if (preg_match('(documents)', $path)) {
    $documents = true;
}

if (preg_match('(users)', $path)) {
    $directory = true;
}

$active = $directory || $documents;
$this->set('moduleBar', $active);

if ($documents) : echo $this->element('ModuleNav/documents'); endif;

if ($directory) : echo $this->element('ModuleNav/directory'); endif;

