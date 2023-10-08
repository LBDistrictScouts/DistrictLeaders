<?php
/**
 * @var AppView $this
 */

use App\View\AppView;

?>
<?= $this->Form->create(null, ['method' => 'post']) ?>
    <div>
        <h2 class="sr-only">Login Form</h2>
        <div class="illustration"><i class="fal fa-unlock-alt"></i></div>
        <?= $this->Form->control('username', ['class' => 'form-control form-control-lg', 'label' => false, 'type' => 'username d-inline', 'id' => 'username', 'name' => 'username', 'placeholder' => 'Username']) ?>

        <?= $this->Form->password('username', ['class' => 'form-control form-control-lg', 'label' => false, 'type' => 'password', 'id' => 'password', 'name' => 'password', 'placeholder' => 'Password']) ?>

        <div class="form-group text-center text-white-50" style="padding-top: 15px;padding-bottom: 15px;">
            <div class="form-check">
                <?= $this->Form->checkbox('remember_me', ['class' => 'form-check-input', 'id' => 'formCheck-1', 'name' => 'remember_me']) ?>
                <?= $this->Form->label('remember_me', 'Remember me on this Computer', ['class' => 'form-check-label']) ?>
            </div>
        </div>
        <div class="form-group d-inline">
            <?= $this->Form->button('Log In', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) ?>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col"><a href="<?php echo $this->Url->build([
                    'controller' => 'Users',
                    'action' => 'username',
                    'prefix' => false], ['_full']); ?>" class="forgot">Forgot your username?</a></div>
            <div class="col"><a href="<?php echo $this->Url->build([
                    'controller' => 'Users',
                    'action' => 'forgot',
                    'prefix' => false], ['_full']); ?>" class="forgot">Forgot your password?</a></div>
        </div>
    </div>
<?= $this->Form->end() ?>

