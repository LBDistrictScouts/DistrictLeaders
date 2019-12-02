<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserContact $userContact
 * @var mixed $userContactTypes
 * @var mixed $users
 * @var string $term
 * @var \App\Model\Entity\User $user
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', $term);

?>
<?= $this->Form->create($userContact) ?>
<fieldset>
    <?php
        echo $this->Form->control($userContact::FIELD_CONTACT_FIELD, ['label' => $term]);
        if (isset($users)) {
            echo $this->Form->control('user_id', ['options' => $users]);
        } else {
            echo $this->Form->control('User', ['disabled' => true, 'options' => [[$user->get($user::FIELD_ID) => $user->get($user::FIELD_FULL_NAME)]]]);
        }
        if (isset($userContactTypes)) {
            echo $this->Form->control('user_contact_type_id', ['options' => $userContactTypes]);
        }
    ?>
</fieldset>
