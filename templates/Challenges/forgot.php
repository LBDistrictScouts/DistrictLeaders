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
                <h3>Request Password Reset Email</h3>
            </div>
            <div class="card-body">
                <?= $this->Form->create($resForm); ?>
                <?= $this->Form->input('email'); ?>
                <?= $this->Form->input('membership_number'); ?>
            </div>
            <div class="card-footer">
                <?= $this->Form->submit('Request Password Reset', ['class' => 'btn btn-success btn-block btn-lg']) ?>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
