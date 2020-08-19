<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompassRecord $compassRecord
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Compass Record'), ['action' => 'edit', $compassRecord->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Compass Record'), ['action' => 'delete', $compassRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $compassRecord->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Compass Records'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Compass Record'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Document Versions'), ['controller' => 'DocumentVersions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document Version'), ['controller' => 'DocumentVersions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="compassRecords view large-9 medium-8 columns content">
    <h3><?= h($compassRecord->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Document Version') ?></th>
            <td><?= $compassRecord->has('document_version') ? $this->Html->link($compassRecord->document_version->version_number, ['controller' => 'DocumentVersions', 'action' => 'view', $compassRecord->document_version->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($compassRecord->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Forenames') ?></th>
            <td><?= h($compassRecord->forenames) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Surname') ?></th>
            <td><?= h($compassRecord->surname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($compassRecord->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address Line1') ?></th>
            <td><?= h($compassRecord->address_line1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address Line2') ?></th>
            <td><?= h($compassRecord->address_line2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address Line3') ?></th>
            <td><?= h($compassRecord->address_line3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address Town') ?></th>
            <td><?= h($compassRecord->address_town) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address County') ?></th>
            <td><?= h($compassRecord->address_county) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Postcode') ?></th>
            <td><?= h($compassRecord->postcode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address Country') ?></th>
            <td><?= h($compassRecord->address_country) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= h($compassRecord->role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= h($compassRecord->location) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= h($compassRecord->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($compassRecord->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($compassRecord->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Membership Number') ?></th>
            <td><?= $this->Number->format($compassRecord->membership_number) ?></td>
        </tr>
    </table>
</div>
