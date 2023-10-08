<?php
/**
 * @var AppView $this
 * @var ResetForm $resForm
 * @var string username
 * @var mixed $username
 */

use App\Form\ResetForm;
use App\View\AppView;

?>
<?= $this->Form->create($resForm); ?>
    <?php if (isset($username)) : ?>
        <div>
            <h2 class="sr-only">Lookup Your Username</h2>
            <div class="illustration"><i class="fal fa-user-tag"></i></div>

            <?= $this->Form->control('your_username_is', ['value' => $username, 'disabled' => true]) ?>

            <div class="form-group d-inline">
                <a href="<?php echo $this->Url->build([
                    'controller' => 'Users',
                    'action' => 'login',
                    'prefix' => false], ['_full']); ?>">
                    <button type="button" class="btn btn-primary btn-block">Login</button></a>
            </div>
            <div class="form-row" style="margin-top: 20px;">
                <div class="col"><a href="<?php echo $this->Url->build([
                        'controller' => 'Users',
                        'action' => 'forgot',
                        'prefix' => false], ['_full']); ?>" class="forgot">Forgot your password?</a></div>
            </div>
        </div>
    <?php else : ?>
            <div>
                <h2 class="sr-only">Lookup Your Username</h2>
                <div class="illustration"><i class="fal fa-user-tag"></i></div>

                <?= $this->Form->control('membership_number'); ?>
                <?= $this->Form->control('first_name'); ?>
                <?= $this->Form->control('last_name'); ?>

                <div class="form-group d-inline">
                    <?= $this->Form->button('Lookup Username', ['class' => 'btn btn-primary btn-block btn-lg', 'type' => 'submit']) ?>
                </div>
                <div class="form-row" style="margin-top: 20px;">
                    <div class="col"><a class="forgot" href="<?php echo $this->Url->build([
                            'controller' => 'Users',
                            'action' => 'login',
                            'prefix' => false], ['_full']); ?>">Login</a></div>
                    <div class="col"><a href="<?php echo $this->Url->build([
                            'controller' => 'Users',
                            'action' => 'forgot',
                            'prefix' => false], ['_full']); ?>" class="forgot">Forgot your password?</a></div>
                </div>
            </div>
    <?php endif; ?>
<?= $this->Form->end(); ?>
