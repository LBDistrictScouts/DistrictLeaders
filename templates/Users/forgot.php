<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Form\ResetForm $resForm
 */
?>
<?= $this->Form->create($resForm); ?>
    <div>
        <h2 class="sr-only">Request Password Reset Email</h2>
        <div class="illustration"><i class="fal fa-user-shield"></i></div>

        <?= $this->Form->control('email'); ?>
        <?= $this->Form->control('membership_number'); ?>

        <div class="form-group d-inline">
            <?= $this->Form->submit('Request Password Reset', ['class' => 'btn btn-primary btn-block btn-lg']) ?>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col"><a class="forgot" href="<?php echo $this->Url->build([
                    'controller' => 'Users',
                    'action' => 'login',
                    'prefix' => false], ['_full']); ?>">Login</a></div>
            <div class="col"><a href="<?php echo $this->Url->build([
                    'controller' => 'Users',
                    'action' => 'username',
                    'prefix' => false], ['_full']); ?>" class="forgot">Forgot your username?</a></div>
        </div>
    </div>
<?= $this->Form->end(); ?>
