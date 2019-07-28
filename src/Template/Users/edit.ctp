<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->extend('../Layout/CRUD/edit');

$this->assign('entity', 'Users');
$this->assign('icon', 'fa-users');

?>
<?= $this->Form->create($user) ?>
<fieldset>
    <?php
        echo $this->Form->control($user::FIELD_USERNAME);
        echo $this->Form->control($user::FIELD_MEMBERSHIP_NUMBER);
        echo $this->Form->control($user::FIELD_FIRST_NAME);
        echo $this->Form->control($user::FIELD_LAST_NAME);
        echo $this->Form->control($user::FIELD_EMAIL);
        echo $this->Form->control($user::FIELD_ADDRESS_LINE_1);
        echo $this->Form->control($user::FIELD_ADDRESS_LINE_2);
        echo $this->Form->control($user::FIELD_CITY);
        echo $this->Form->control($user::FIELD_COUNTY);
        echo $this->Form->control($user::FIELD_POSTCODE);
    ?>
</fieldset>
