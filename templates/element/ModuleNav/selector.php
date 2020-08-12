<?php
/**
 * @var \App\View\AppView $this
 * @var int $loggedInUserId
 */

$path = $this->getRequest()->getPath();

$directory = false;
$documents = false;
$groups = false;
$queue = false;
$admin = false;

if (preg_match('(documents)', $path)) {
    $documents = true;
}

if (preg_match('(users)', $path)) {
    $directory = true;
}

if (preg_match('(groups|sections)', $path)) {
    $groups = true;
}

if (preg_match('(queue)', $path)) {
    $queue = true;
}

if (preg_match('(admin|directories|directory)', $path) && !$queue) {
    $admin = true;
}

$active = $directory || $documents || $groups || $queue || $admin;
$this->set('moduleBar', $active);

if ($documents) :
    echo $this->element('ModuleNav/documents');
endif;

if ($directory && !$admin) :
    echo $this->element('ModuleNav/directory');
endif;

if ($groups && !$admin) :
    echo $this->element('ModuleNav/groups');
endif;

if ($admin) :
    echo $this->element('ModuleNav/admin');
endif;

if ($queue) :
    echo $this->element('ModuleNav/queue');
endif;
