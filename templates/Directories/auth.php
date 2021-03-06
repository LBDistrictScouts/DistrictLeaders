<?php
/**
 * @var \App\View\AppView $this
 * @var string $authUrl
 * @var \App\Form\GoogleAuthForm $form
 */

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'GoogleAuthCode');
$this->assign('icon', 'fa-google');

?>
<div class="row">
    <div class="col-12">
        <a class="btn btn-lg btn-outline-primary" href="<?= $authUrl ?>">Authorise Directory</a>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-12">
        <?= $this->Form->create($form) ?>
        <fieldset>
            <?php
            echo $this->Form->control('auth_code');
            ?>
        </fieldset>
    </div>
</div>

