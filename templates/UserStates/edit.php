<?php
/**
 * @var AppView $this
 * @var UserState $userState
 */

use App\Model\Entity\UserState;
use App\View\AppView;

$this->extend('../layout/CRUD/edit');

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
