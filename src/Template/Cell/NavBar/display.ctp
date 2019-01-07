<?php
/**
 * @var \App\View\AppView $this
 * @var array $capabilities
 */
?>
<?php if (in_array('LOGIN',$capabilities['user'])) : ?>
<li class="nav-item active">
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
	<a class="nav-link" href="#">Link</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="#">Disabled</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="#">Jacob Tyler <i class="fal fa-user-cog"></i></a>
</li>