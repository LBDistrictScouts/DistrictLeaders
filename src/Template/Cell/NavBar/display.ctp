<?php
/**
 * @var \App\View\AppView $this
 * @var array $capabilities
 * @var integer $loggedInUserId
 * @var string $name
 */
?>
<?php if (in_array('LOGIN',$capabilities['user'])) : ?>
<li class="nav-item">
	<div class="dropdown">
		<a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Dropdown button
		</a>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" href="#">Action</a>
			<a class="dropdown-item" href="#">Another action</a>
			<a class="dropdown-item" href="#">Something else here</a>
		</div>
	</div>
</li>
<?php endif; ?>
<li class="nav-item">
    <?= $this->Html->link('Groups', ['controller' => 'ScoutGroups', 'action' => 'index'], ['class' => 'nav-link'])  ?>
</li>
<li class="nav-item">
    <?= $this->Html->link('District Directory', ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link'])  ?>
</li>
<li class="nav-item">
    <div class="dropdown">
        <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fal fa-user"></i> <?= h($name) ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?= $this->Html->link('View Details', ['controller' => 'Users', 'action' => 'view', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
            <?= $this->Html->link('Edit Details', ['controller' => 'Users', 'action' => 'edit', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
            <?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'dropdown-item'])  ?>
        </div>
    </div>
</li>