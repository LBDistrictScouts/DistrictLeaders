<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var mixed $passwordStates
 */

$this->extend('../Layout/CRUD/edit');

$this->assign('entity', 'Users');
?>
<?= $this->Form->create($user) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $user->getSource(),
            null,
            null,
        ];

        $args[4] = $user::FIELD_USERNAME;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_USERNAME) : '';

        $args[4] = $user::FIELD_MEMBERSHIP_NUMBER;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_MEMBERSHIP_NUMBER) : '';

        $args[4] = $user::FIELD_FIRST_NAME;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_FIRST_NAME) : '';

        $args[4] = $user::FIELD_LAST_NAME;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_LAST_NAME) : '';

        $args[4] = $user::FIELD_EMAIL;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_EMAIL) : '';

        $args[4] = $user::FIELD_PASSWORD;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_PASSWORD) : '';

        $args[4] = $user::FIELD_ADDRESS_LINE_1;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_ADDRESS_LINE_1) : '';

        $args[4] = $user::FIELD_ADDRESS_LINE_2;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_ADDRESS_LINE_2) : '';

        $args[4] = $user::FIELD_CITY;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_CITY) : '';

        $args[4] = $user::FIELD_COUNTY;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_COUNTY) : '';

        $args[4] = $user::FIELD_POSTCODE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_POSTCODE) : '';

        $args[4] = $user::FIELD_LAST_LOGIN;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_LAST_LOGIN) : '';

        $args[4] = $user::FIELD_LAST_LOGIN_IP;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_LAST_LOGIN_IP) : '';

        $args[4] = $user::FIELD_CAPABILITIES;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_CAPABILITIES) : '';

        $args[4] = $user::FIELD_PASSWORD_STATE_ID;
        /** @var array $passwordStates The Password State Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($user::FIELD_PASSWORD_STATE_ID, ['options' => $passwordStates, 'empty' => true]) : '';

    ?>
</fieldset>