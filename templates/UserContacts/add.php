<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserContact $userContact
 * @var mixed $userContactTypes
 * @var mixed $users
 */

$this->extend('../Layout/CRUD/add');

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

        $args[4] = $userContact::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($userContact::FIELD_ID) : '';

        $args[4] = $userContact::FIELD_CONTACT_FIELD;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($userContact::FIELD_CONTACT_FIELD) : '';

        $args[4] = $userContact::FIELD_USER_ID;
        /** @var array $users The User Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($userContact::FIELD_USER_ID, ['options' => $users]) : '';

        $args[4] = $userContact::FIELD_USER_CONTACT_TYPE_ID;
        /** @var array $userContactTypes The User Contact Type Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($userContact::FIELD_USER_CONTACT_TYPE_ID, ['options' => $userContactTypes]) : '';

        $args[4] = $userContact::FIELD_VERIFIED;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($userContact::FIELD_VERIFIED) : '';

    ?>
</fieldset>