<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserContact $userContact
 * @var mixed $userContactTypes
 * @var mixed $users
 * @var string $term
 * @var \App\Model\Entity\User $user
 */

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'UserContacts');
?>
<?= $this->Form->create($userContact) ?>
<fieldset>
    <?php
    $args = [
        'CHANGE',
        $userContact->getSource(),
        null,
        null,
    ];

    $args[4] = $userContact::FIELD_CONTACT_FIELD;
    echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($userContact::FIELD_CONTACT_FIELD, ['label' => $term]) : '';

    $args[4] = $userContact::FIELD_USER_ID;
    if (isset($users)) {
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control('user_id', ['options' => $users]) : '';
    } else {
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control('User', ['disabled' => true, 'options' => [[$user->get($user::FIELD_ID) => $user->get($user::FIELD_FULL_NAME)]]]) : '';
    }

    $args[4] = $userContact::FIELD_USER_CONTACT_TYPE_ID;
    if (isset($userContactTypes)) {
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control('user_contact_type_id', ['options' => $userContactTypes]) : '';
    }
    ?>
</fieldset>
