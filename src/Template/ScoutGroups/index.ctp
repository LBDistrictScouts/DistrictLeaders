<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ScoutGroup[]|\Cake\Collection\CollectionInterface $scoutGroups
 */

$this->extend('../Layout/CRUD/index');

$this->assign('entity', 'ScoutGroups');
$this->assign('subset', 'All');
$this->assign('icon', 'fa-paw');

?>

<thead>
<tr>
    <th scope="col"><?= $this->Paginator->sort('scout_group') ?></th>
    <th scope="col" class="actions"><?= __('Actions') ?></th>
    <th scope="col"><?= $this->Paginator->sort('group_domain') ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($scoutGroups as $scoutGroup): ?>
    <tr>
        <td><?= h($scoutGroup->scout_group) ?></td>
        <td class="actions">
            <?= $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $scoutGroup->id], ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
            <?= $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $scoutGroup->id], ['title' => __('Edit'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
            <?= $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $scoutGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scoutGroup->id), 'title' => __('Delete'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
        </td>
        <td><?= $this->Text->autoLinkUrls($scoutGroup->group_domain) ?></td>
    </tr>
<?php endforeach; ?>
</tbody>
