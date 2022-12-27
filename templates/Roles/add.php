<?php
/**
 * @var AppView $this
 * @var Role $role
 * @var Query $roleStatuses
 * @var Query $roleTypes
 * @var Query $sections
 * @var Query $users
 * @var User $user
 */

use App\Model\Entity\Role;
use App\Model\Entity\User;
use App\View\AppView;
use Cake\ORM\Query;

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'Roles');
?>
<?= $this->Form->create($role) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $role->getSource(),
            null,
            null,
        ];

        $args[4] = $role::FIELD_ROLE_TYPE_ID;
        /** @var array $roleTypes The Role Type Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($role::FIELD_ROLE_TYPE_ID, ['options' => $roleTypes]) : '';

        $args[4] = $role::FIELD_SECTION_ID;
        /** @var array $sections The Section Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($role::FIELD_SECTION_ID, ['options' => $sections]) : '';

        $args[4] = $role::FIELD_USER_ID;
        if (isset($users)) {
            echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control('user_id', ['options' => $users]) : '';
        } else {
            echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control('User', ['disabled' => true, 'options' => [[$user->get($user::FIELD_ID) => $user->get($user::FIELD_FULL_NAME)]]]) : '';
        }

        $args[4] = $role::FIELD_ROLE_STATUS_ID;
        /** @var array $roleStatuses The Role Status Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($role::FIELD_ROLE_STATUS_ID, ['options' => $roleStatuses]) : '';

        ?>
</fieldset>
