<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'Users');
$this->assign('icon', 'fa-users');

?>
<?= $this->Form->create($user) ?>
<fieldset>
    <?php
        echo $this->Form->control('membership_number');
        echo $this->Form->control('first_name');
        echo $this->Form->control('last_name');
        echo $this->Form->control('email');
        echo $this->Form->control('address_line_1');
        echo $this->Form->control('address_line_2');
        echo $this->Form->control('city');
        echo $this->Form->control('county');
        echo $this->Form->control('postcode');
    ?>
</fieldset>
