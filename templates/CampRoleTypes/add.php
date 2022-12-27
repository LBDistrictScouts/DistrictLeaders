<?php
/**
 * @var AppView $this
 * @var CampRoleType $campRoleType
 */

use App\Model\Entity\CampRoleType;
use App\View\AppView;

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'CampRoleTypes');
?>
<?= $this->Form->create($campRoleType) ?>
<fieldset>
    <?php
        $args = [
            'CREATE',
            $campRoleType->getSource(),
            null,
            null,
        ];

        $args[4] = $campRoleType::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campRoleType::FIELD_ID) : '';

        $args[4] = $campRoleType::FIELD_CAMP_ROLE_TYPE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campRoleType::FIELD_CAMP_ROLE_TYPE) : '';

        ?>
</fieldset>
