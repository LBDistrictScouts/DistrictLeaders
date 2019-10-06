<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Form\ResetForm $resForm
 * @var mixed $passwordForm
 */
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-6">
        <div class="login-card card card-default">
            <div class="card-header">
                <h3>Request Password Reset Email</h3>
            </div>
            <div class="card-body">
				<?= $this->Form->create($resForm); ?>
				<?= $this->Form->input('email'); ?>
				<?= $this->Form->input('membership_number'); ?>
            </div>
            <div class="card-footer">
				<?= $this->Form->submit('Request Password Reset',['class' => 'btn btn-success btn-block btn-lg']) ?>
            </div>
			<?= $this->Form->end(); ?>
        </div>
    </div>
</div>


<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Enter details to request a password reset.</h3>
                </div>
                <div class="panel-body">
					<?= $this->Form->create($passwordForm); ?>
					<?= $this->Form->input('newpw', ['label' => 'Enter a New Password.', 'type' => 'password']); ?>
					<?= $this->Form->input('confirm', ['label' => 'Confirm Password.', 'type' => 'password']); ?>
					<?= $this->Form->input('postcode', ['label' => 'Enter Postcode.']); ?>
					<?= $this->Form->button('Change Password') ?>
					<?= $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>