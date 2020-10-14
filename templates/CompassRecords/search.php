<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompassRecord[]|\Cake\Collection\CollectionInterface $compassRecords
 */

use App\Model\Entity\CompassRecord;

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompassRecord[]|\Cake\Collection\CollectionInterface $compassRecords
 */

$this->extend('../layout/CRUD/search');

$this->assign('entity', 'CompassRecords');
$this->assign('subset', 'All');
$this->assign('add', false);

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort(CompassRecord::FIELD_FULL_NAME) ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort(CompassRecord::FIELD_DOCUMENT_VERSION_ID) ?></th>
        <th scope="col"><?= $this->Paginator->sort(CompassRecord::FIELD_MEMBERSHIP_NUMBER) ?></th>
        <th scope="col"><?= $this->Paginator->sort(CompassRecord::FIELD_CLEAN_ROLE) ?></th>
        <th scope="col"><?= $this->Paginator->sort(CompassRecord::FIELD_CLEAN_SECTION) ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($compassRecords as $compassRecord) : ?>
    <tr>
        <td><?= h($compassRecord->full_name) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_COMPASS_RECORD') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $compassRecord->id], ['title' => __('View Compass Record'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_COMPASS_RECORD') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $compassRecord->id], ['title' => __('Edit Compass Record'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_COMPASS_RECORD') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $compassRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $compassRecord->id), 'title' => __('Delete Compass Record'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Html->link($compassRecord->document_version->document->document, ['controller' => 'Documents', 'action' => 'view', $compassRecord->document_version->document->id]) ?></td>
        <td><?= h($compassRecord->membership_number) ?></td>
        <td><?= h($compassRecord->clean_role) ?></td>
        <td><?= h($compassRecord->clean_section) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
