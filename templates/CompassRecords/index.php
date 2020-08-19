<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompassRecord[]|\Cake\Collection\CollectionInterface $compassRecords
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'CompassRecords');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_COMPASS_RECORD'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('title') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('document_version_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('membership_number') ?></th>
        <th scope="col"><?= $this->Paginator->sort('forenames') ?></th>
        <th scope="col"><?= $this->Paginator->sort('surname') ?></th>
        <th scope="col"><?= $this->Paginator->sort('address') ?></th>
        <th scope="col"><?= $this->Paginator->sort('address_line1') ?></th>
        <th scope="col"><?= $this->Paginator->sort('address_line2') ?></th>
        <th scope="col"><?= $this->Paginator->sort('address_line3') ?></th>
        <th scope="col"><?= $this->Paginator->sort('address_town') ?></th>
        <th scope="col"><?= $this->Paginator->sort('address_county') ?></th>
        <th scope="col"><?= $this->Paginator->sort('postcode') ?></th>
        <th scope="col"><?= $this->Paginator->sort('address_country') ?></th>
        <th scope="col"><?= $this->Paginator->sort('role') ?></th>
        <th scope="col"><?= $this->Paginator->sort('location') ?></th>
        <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
        <th scope="col"><?= $this->Paginator->sort('email') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($compassRecords as $compassRecord) : ?>
    <tr>
        <td><?= h($compassRecord->title) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_COMPASS_RECORD') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $compassRecord->id], ['title' => __('View Compass Record'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_COMPASS_RECORD') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $compassRecord->id], ['title' => __('Edit Compass Record'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_COMPASS_RECORD') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $compassRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $compassRecord->id), 'title' => __('Delete Compass Record'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Number->format($compassRecord->document_version_id) ?></td>
        <td><?= $this->Number->format($compassRecord->membership_number) ?></td>
        <td><?= h($compassRecord->forenames) ?></td>
        <td><?= h($compassRecord->surname) ?></td>
        <td><?= h($compassRecord->address) ?></td>
        <td><?= h($compassRecord->address_line1) ?></td>
        <td><?= h($compassRecord->address_line2) ?></td>
        <td><?= h($compassRecord->address_line3) ?></td>
        <td><?= h($compassRecord->address_town) ?></td>
        <td><?= h($compassRecord->address_county) ?></td>
        <td><?= h($compassRecord->postcode) ?></td>
        <td><?= h($compassRecord->address_country) ?></td>
        <td><?= h($compassRecord->role) ?></td>
        <td><?= h($compassRecord->location) ?></td>
        <td><?= h($compassRecord->phone) ?></td>
        <td><?= h($compassRecord->email) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>