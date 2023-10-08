<?php
/**
 * @var AppView $this
 * @var DirectoryUser $directoryUser
 * @var mixed $directories
 */

use App\Model\Entity\DirectoryUser;
use App\View\AppView;

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'DirectoryUsers');
?>
<?= $this->Form->create($directoryUser) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $directoryUser->getSource(),
            null,
            null,
        ];

        $args[4] = $directoryUser::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryUser::FIELD_ID) : '';

        $args[4] = $directoryUser::FIELD_DIRECTORY_ID;
        /** @var array $directories The Directory Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryUser::FIELD_DIRECTORY_ID, ['options' => $directories]) : '';

        $args[4] = $directoryUser::FIELD_DIRECTORY_USER_REFERENCE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryUser::FIELD_DIRECTORY_USER_REFERENCE) : '';

        $args[4] = $directoryUser::FIELD_GIVEN_NAME;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryUser::FIELD_GIVEN_NAME) : '';

        $args[4] = $directoryUser::FIELD_FAMILY_NAME;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryUser::FIELD_FAMILY_NAME) : '';

        $args[4] = $directoryUser::FIELD_PRIMARY_EMAIL;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryUser::FIELD_PRIMARY_EMAIL) : '';

        ?>
</fieldset>
