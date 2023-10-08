<?php
/**
 * @var AppView $this
 * @var Capability $capability
 * @var mixed $roleTypes
 */

use App\Model\Entity\Capability;
use App\View\AppView;

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'Capabilities');
?>
<?= $this->Form->create($capability) ?>
<fieldset>
    <?php
        $args = [
            'CREATE',
            $capability->getSource(),
            null,
            null,
        ];

        $args[4] = $capability::FIELD_CAPABILITY_CODE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($capability::FIELD_CAPABILITY_CODE) : '';

        $args[4] = $capability::FIELD_CAPABILITY;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($capability::FIELD_CAPABILITY) : '';

        $args[4] = $capability::FIELD_MIN_LEVEL;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($capability::FIELD_MIN_LEVEL) : '';
        ?>
</fieldset>
