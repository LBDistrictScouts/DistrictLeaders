<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ScoutGroup[]|\Cake\Collection\CollectionInterface $scoutGroups
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'ScoutGroups');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_SCOUT_GROUP'));

?>
<thead>
<tr>
    <th scope="col"><?= $this->Paginator->sort('scout_group') ?></th>
    <th scope="col" class="actions"><?= __('Actions') ?></th>
    <th scope="col"><?= $this->Paginator->sort('group_domain') ?></th>
</tr>
</thead>
<tbody>
    <?php foreach ($scoutGroups as $scoutGroup) : ?>
    <tr>
        <td><?= h($scoutGroup->group_alias) ?></td>
        <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_SCOUT_GROUP') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $scoutGroup->id], ['title' => __('View Scout Group'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_SCOUT_GROUP') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $scoutGroup->id], ['title' => __('Edit Scout Group'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_SCOUT_GROUP') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $scoutGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scoutGroup->id), 'title' => __('Delete Scout Group'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Html->link($scoutGroup->clean_domain, $scoutGroup->group_domain) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
