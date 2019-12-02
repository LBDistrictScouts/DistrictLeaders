<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 * @var array $roleStatuses
 * @var array $roleTypes
 * @var array $sections
 * @var array $userContacts
 */
?>
<div class="roles form large-9 medium-8 columns content">
    <?= $this->Form->create($role) ?>
    <fieldset>
        <legend><?= __('Edit Role') ?></legend>
        <?php
            echo $this->Form->control('role_type_id', ['options' => $roleTypes]);
            echo $this->Form->control('section_id', ['options' => $sections]);
            echo $this->Form->control('role_status_id', ['options' => $roleStatuses]);
            echo $this->Form->control('user_contact_id', ['options' => $userContacts]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
