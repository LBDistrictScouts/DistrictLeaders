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
<?= $this->Form->create($passwordForm, ['method' => 'post']) ?>
<div>
    <h2 class="sr-only">Login Form</h2>
    <div class="illustration"><i class="fal fa-unlock-alt"></i></div>
    <?= $this->Form->control('username', ['class' => 'form-control form-control-lg', 'label' => false, 'type' => 'username', 'id' => 'username', 'name' => 'username', 'placeholder' => 'Choose a Username']) ?>

    <?= $this->Form->control($passwordForm::FIELD_NEW_PASSWORD, ['class' => 'form-control form-control-lg', 'label' => false, 'placeholder' => 'Password', 'type' => 'password']); ?>
    <?= $this->Form->control($passwordForm::FIELD_CONFIRM_PASSWORD, ['class' => 'form-control form-control-lg', 'label' => false, 'placeholder' => 'Confirm Password', 'type' => 'password']); ?>

    <div class="form-group d-inline">
        <?= $this->Form->button('Set my Credentials', ['class' => 'btn btn-success btn-block', 'type' => 'submit']) ?>
    </div>
</div>
<?= $this->Form->end() ?>
