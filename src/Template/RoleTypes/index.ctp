<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleType[]|\Cake\Collection\CollectionInterface $roleTypes
 */
?>

<?php
use App\Model\Entity\RoleType;

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleType[]|\Cake\Collection\CollectionInterface $roleTypes
 * @var \App\Model\Entity\User $authUser
 */

$authUser = $this->request->getAttribute('identity');

$this->extend('../Layout/CRUD/index');

$this->assign('entity', 'RoleTypes');
$this->assign('subset', 'All');

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort(RoleType::FIELD_ROLE_TYPE) ?></th>
        <th scope="col"><?= $this->Paginator->sort(RoleType::FIELD_ROLE_ABBREVIATION) ?></th>
        <th scope="col"><?= $this->Paginator->sort(RoleType::FIELD_LEVEL) ?></th>
        <th scope="col"><?= $this->Paginator->sort(RoleType::FIELD_SECTION_TYPE_ID) ?></th>
        <th scope="col"><?= $this->Paginator->sort(RoleType::FIELD_ROLE_TEMPLATE_ID) ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($roleTypes as $roleType): ?>
    <tr>
        <td><?= h($roleType->role_type) ?></td>
        <td><?= h($roleType->role_abbreviation) ?></td>
        <td><?= $this->Number->format($roleType->level) ?></td>
        <td><?= $roleType->has(RoleType::FIELD_SECTION_TYPE) ? $this->Html->link($roleType->section_type->section_type, ['controller' => 'SectionTypes', 'action' => 'view', $roleType->section_type->id]) : '' ?></td>
        <td><?= $roleType->has(RoleType::FIELD_ROLE_TEMPLATE) ? $this->Html->link($roleType->role_template->role_template, ['controller' => 'RoleTemplates', 'action' => 'view', $roleType->role_template->id]) : '' ?></td>
        <td class="actions">
            <?= $this->Html->link(__('View'), ['action' => 'view', $roleType->id]) ?>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $roleType->id]) ?>
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $roleType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roleType->id)]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
