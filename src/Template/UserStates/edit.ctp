<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserState $userState
 */

$this->extend('../Layout/CRUD/edit');

$this->assign('entity', 'UserStates');
?>
<?= $this->Form->create($userState) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $userState->getSource(),
            null,
            null,
        ];

        $args[4] = $userState::FIELD_USER_STATE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($userState::FIELD_USER_STATE) : '';

        $args[4] = $userState::FIELD_ACTIVE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($userState::FIELD_ACTIVE) : '';

        $args[4] = $userState::FIELD_EXPIRED;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($userState::FIELD_EXPIRED) : '';

    ?>
</fieldset>