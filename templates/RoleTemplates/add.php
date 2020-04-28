<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleTemplate $roleTemplate
 * @var mixed $capabilities
 */

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'RoleTemplates');
?>
<?= $this->Form->create($roleTemplate) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $roleTemplate->getSource(),
            null,
            null,
        ];

        $args[4] = $roleTemplate::FIELD_ROLE_TEMPLATE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleTemplate::FIELD_ROLE_TEMPLATE) : '';

        $args[4] = $roleTemplate::FIELD_INDICATIVE_LEVEL;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleTemplate::FIELD_INDICATIVE_LEVEL) : '';

        $args[4] = $roleTemplate::FIELD_TEMPLATE_CAPABILITIES;
        /** @var array $capabilities */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleTemplate::FIELD_TEMPLATE_CAPABILITIES, ['options' => $capabilities, 'label' => false, 'multiple' => 'checkbox']) : '';

        ?>
</fieldset>
