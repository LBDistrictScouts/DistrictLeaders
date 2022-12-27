<?php
/**
 * @var AppView $this
 * @var RoleStatus $roleStatus
 */

use App\Model\Entity\RoleStatus;
use App\View\AppView;

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'RoleStatuses');
?>
<?= $this->Form->create($roleStatus) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $roleStatus->getSource(),
            null,
            null,
        ];

        $args[4] = $roleStatus::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleStatus::FIELD_ID) : '';

        $args[4] = $roleStatus::FIELD_ROLE_STATUS;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleStatus::FIELD_ROLE_STATUS) : '';

        ?>
</fieldset>
