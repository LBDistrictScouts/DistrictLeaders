<?php
/**
 * @var AppView $this
 * @var Camp[]|CollectionInterface $camps
 */
use App\Model\Entity\Camp;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'Camps');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_CAMP'));

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
            <?= $this->Identity->checkCapability('VIEW_CAMP') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $camp->id], ['title' => __('View Camp'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_CAMP') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $camp->id], ['title' => __('Edit Camp'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_CAMP') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $camp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $camp->id), 'title' => __('Delete Camp'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $camp->has(Camp::FIELD_CAMP_TYPE_ID) ? $camp->camp_type->camp_type : '' ?></td>
        <td><?= $this->Time->format($camp->camp_start, 'dd-MMM-yy HH:mm') ?></td>
        <td><?= $this->Time->format($camp->camp_end, 'dd-MMM-yy HH:mm') ?></td>

    </tr>
    <?php endforeach; ?>
</tbody>
