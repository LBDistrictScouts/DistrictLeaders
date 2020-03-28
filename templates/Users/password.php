<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Form\ResetForm $resForm
 * @var \App\Form\PasswordForm $passwordForm
 */
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-6">
        <div class="login-card card card-default">
            <div class="card-header">
                <h3>Enter New Password.</h3>
            </div>
            <div class="card-body">
                <?= $this->Form->create($passwordForm) ?>
                <?= $this->Form->control($passwordForm::FIELD_NEW_PASSWORD, ['label' => 'Enter a New Password.', 'type' => 'password']); ?>
                <?= $this->Form->control($passwordForm::FIELD_CONFIRM_PASSWORD, ['label' => 'Confirm Password.', 'type' => 'password']); ?>
                <?= $this->Form->control($passwordForm::FIELD_POSTCODE, ['label' => 'Enter Postcode.']); ?>
            </div>
            <div class="card-footer">
                <?= $this->Form->submit('Change Password', ['class' => 'btn btn-success btn-block btn-lg']) ?>
            </div>
			<?= $this->Form->end(); ?>
        </div>
    </div>
</div>
