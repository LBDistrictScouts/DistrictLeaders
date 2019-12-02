<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserContact $userContact
 * @var mixed $userContactTypes
 * @var mixed $users
 */
?>
<div class="userContacts form large-9 medium-8 columns content">
    <?= $this->Form->create($userContact) ?>
    <fieldset>
        <legend><?= __('Edit User Contact') ?></legend>
        <?php
            echo $this->Form->control('contact_field');
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('user_contact_type_id', ['options' => $userContactTypes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
