<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $PolicyResult
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
$this->set('searchBar', $active);

?>

<ul class="navbar-nav move-right mt-2 mt-lg-0">
    <?= $documents ? $this->element('Search/documents') : '' ?>
    <?= $directory && !$admin ? $this->element('Search/directory') : '' ?>
    <?= $groups && !$admin ? $this->element('Search/groups') : '' ?>
    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="color: #7413db;font-family: 'Nunito Sans', sans-serif;"><i class="fw fal fa-user"></i><?= isset($active) && $active ? '' : ' ' . h($this->Identity->getName()) ?></a>
        <div class="dropdown-menu" role="menu">
            <?= $this->cell('ProfileModal', [$this->Identity->getId()], [
                'cache' => [
                    'config' => 'cell_cache',
                    'key' => 'profile_modal_' . $this->Identity->getId(),
                ],
            ])->render() ?>
        </div>
    </li>
    <li class="nav-item right-align mr-auto">
        <a class="nav-link" data-toggle="modal" data-target="#notify">
            <i class="fal fa-bell"></i>
        </a>
    </li>
    <?php if (isset($PolicyResult)) : ?>
        <li class="nav-item right-align mr-auto">
            <a class="nav-link" data-toggle="modal" data-target="#whyAuth">
                <i class="fal fa-unlock"></i>
            </a>
        </li>
    <?php endif; ?>
</ul>


