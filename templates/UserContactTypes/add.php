<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserContactType $userContactType
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'UserContactTypes');
?>
<?= $this->Form->create($userContactType) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $userContactType->getSource(),
            null,
            null,
        ];

        $args[4] = $userContactType::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($userContactType::FIELD_ID) : '';

        $args[4] = $userContactType::FIELD_USER_CONTACT_TYPE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($userContactType::FIELD_USER_CONTACT_TYPE) : '';

    ?>
</fieldset>