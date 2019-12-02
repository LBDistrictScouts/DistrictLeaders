<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $capabilities
 * @var \App\Model\Entity\RoleTemplate $roleTemplate
 */
use App\Model\Entity\RoleTemplate;

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleTemplate $roleTemplate
 */

$this->extend('../Layout/CRUD/edit');

$this->assign('entity', 'Users');
$this->assign('icon', 'fa-users');
?>
<?= $this->Form->create($roleTemplate) ?>
<fieldset>
    <?php
        echo $this->Form->control(RoleTemplate::FIELD_ROLE_TEMPLATE);
        echo $this->Form->control(RoleTemplate::FIELD_INDICATIVE_LEVEL);
        echo $this->Form->select(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, $capabilities, ['multiple' => 'checkbox']);
    ?>
</fieldset>
