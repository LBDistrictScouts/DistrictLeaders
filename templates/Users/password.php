<?php
/**
 * @var AppView $this
 * @var ResetForm $resForm
 * @var PasswordForm $passwordForm
 */

use App\Form\PasswordForm;
use App\Form\ResetForm;
use App\View\AppView;

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
