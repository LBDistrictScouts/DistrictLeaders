<?php
/**
 * @var AppView $this
 * @var UserContactType $userContactType
 */

use App\Model\Entity\UserContactType;
use App\View\AppView;

$this->extend('../layout/CRUD/add');

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
