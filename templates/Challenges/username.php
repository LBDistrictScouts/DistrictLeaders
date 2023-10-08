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

<?php if (isset($username)) : ?>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="login-card card card-default">
                <div class="card-header">
                    <h3>Your Username</h3>
                </div>
                <div class="card-body text-center">
                    <p>Your username is: <strong><?= h($username) ?></strong></p>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <a href="<?php echo $this->Url->build([
                                'controller' => 'Users',
                                'action' => 'login',
                                'prefix' => false], ['_full']); ?>">
                                <button type="button" class="btn btn-primary btn-block float-md-right">Login</button></a>
                        </div>
                        <div class="col d-lg-none d-xl-none d-md-none"><br/></div>
                        <div class="col-md-6 col-12">
                            <a href="<?php echo $this->Url->build([
                                'controller' => 'Users',
                                'action' => 'forgot',
                                'prefix' => false], ['_full']); ?>">
                                <button type="button" class="btn btn-default btn-block float-md-right">Forgot Password</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="login-card card card-default">
                <div class="card-header">
                    <h3>Lookup Your Username</h3>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($resForm); ?>
                    <?= $this->Form->input('membership_number'); ?>
                    <?= $this->Form->input('first_name'); ?>
                    <?= $this->Form->input('last_name'); ?>
                </div>
                <div class="card-footer">
                    <?= $this->Form->submit('Lookup Username', ['class' => 'btn btn-success btn-block btn-lg']) ?>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
