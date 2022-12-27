<?php
/**
 * @var AppView $this
 */

use App\View\AppView;

?>
<?= $this->element('header', ['current' => 'import']) ?>
<div class="releases form large-9 medium-8 columns content">
    <h1>Import</h1>

    <?= $this->Form->create(null, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __d('queue', 'Import Job from exported JSON') ?></legend>
        <?php
            echo $this->Form->control('file', ['type' => 'file', 'required' => true, 'accept' => '.json']);
            echo $this->Form->control('reset', ['type' => 'checkbox', 'default' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__d('queue', 'Submit')) ?>
    <?= $this->Form->end() ?>
</div>
