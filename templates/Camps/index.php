<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Camp[]|\Cake\Collection\CollectionInterface $camps
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'Camps');
$this->assign('subset', 'All');

use App\Model\Entity\Camp;

?>

<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort(Camp::FIELD_CAMP_NAME) ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort(Camp::FIELD_CAMP_TYPE_ID) ?></th>
        <th scope="col"><?= $this->Paginator->sort(Camp::FIELD_CAMP_START) ?></th>
        <th scope="col"><?= $this->Paginator->sort(Camp::FIELD_CAMP_END) ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($camps as $camp) : ?>
    <tr>
        <td><?= h($camp->camp_name) ?></td>
        <td class="actions">
            <?= $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $camp->id], ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
            <?= $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $camp->id], ['title' => __('Edit'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
            <?= $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $camp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $camp->id), 'title' => __('Delete'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
        </td>
        <td><?= $camp->has(Camp::FIELD_CAMP_TYPE_ID) ? $camp->camp_type->camp_type : '' ?></td>
        <td><?= $this->Time->format($camp->camp_start, 'dd-MMM-yy HH:mm') ?></td>
        <td><?= $this->Time->format($camp->camp_end, 'dd-MMM-yy HH:mm') ?></td>

    </tr>
    <?php endforeach; ?>
</tbody>
