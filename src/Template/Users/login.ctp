<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Form\ResetForm $resForm
 */
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-6">
        <div class="login-card card card-default">
            <div class="card-header">
                <h3>Leader Login</h3>
            </div>
            <div class="card-body">
                <?= $this->Form->create() ?>
                <?= $this->Form->control('username') ?>
                <?= $this->Form->control('password') ?>
                <?= $this->Form->checkbox('remember_me') ?> Remember me on this Computer<br/>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-12">
	                    <?= $this->Form->button('Login',['class' => 'btn btn-primary btn-lg btn-block']) ?>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <a href="<?php echo $this->Url->build([
			                'controller' => 'Users',
			                'action' => 'username',
			                'prefix' => false],['_full']); ?>">
                            <button type="button" class="btn btn-default btn-block float-md-right">Forgot Username</button></a>
                    </div>
                    <div class="col d-lg-none d-xl-none d-md-none"><br/></div>
                    <div class="col-md-6 col-12">
                        <a href="<?php echo $this->Url->build([
		                    'controller' => 'Users',
		                    'action' => 'reset',
		                    'prefix' => false],['_full']); ?>">
                            <button type="button" class="btn btn-default btn-block float-md-right">Forgot Password</button></a>
                    </div>
                </div>
            </div>
	        <?= $this->Form->end() ?>
        </div>
    </div>
</div>