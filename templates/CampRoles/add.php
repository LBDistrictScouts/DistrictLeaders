<?php
/**
 * @var AppView $this
 * @var CampRole $campRole
 * @var mixed $campRoleTypes
 * @var mixed $camps
 * @var mixed $users
 */

use App\Model\Entity\CampRole;
use App\View\AppView;

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'CampRoles');
?>
<?= $this->Form->create($campRole) ?>
<fieldset>
    <?php
        $args = [
            'CREATE',
            $campRole->getSource(),
            null,
            null,
        ];

        $args[4] = $campRole::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campRole::FIELD_ID) : '';

        $args[4] = $campRole::FIELD_CAMP_ID;
        /** @var array $camps The Camp Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campRole::FIELD_CAMP_ID, ['options' => $camps]) : '';

        $args[4] = $campRole::FIELD_USER_ID;
        /** @var array $users The User Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campRole::FIELD_USER_ID, ['options' => $users]) : '';

        $args[4] = $campRole::FIELD_CAMP_ROLE_TYPE_ID;
        /** @var array $campRoleTypes The Camp Role Type Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campRole::FIELD_CAMP_ROLE_TYPE_ID, ['options' => $campRoleTypes]) : '';

        ?>
</fieldset>
