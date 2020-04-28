<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentVersion[]|\Cake\Collection\CollectionInterface $documentVersions
 * @var \App\Model\Entity\User $authUser
 */

$authUser = $this->getRequest()->getAttribute('identity');

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'DocumentVersions');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_DOCUMENT_VERSION'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('document_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('version_number') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($documentVersions as $documentVersion): ?>
    <tr>
        <td><?= $documentVersion->has('document') ? $this->Html->link($documentVersion->document->document, ['controller' => 'Documents', 'action' => 'view', $documentVersion->document->id]) : '' ?></td>
        <td><?= h($documentVersion->version_number) ?></td>
        <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_DOCUMENT_VERSION') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $documentVersion->id], ['title' => __('View Document Version'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_DOCUMENT_VERSION') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $documentVersion->id], ['title' => __('Edit Document Version'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_DOCUMENT_VERSION') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $documentVersion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentVersion->id), 'title' => __('Delete Document Version'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Time->format($documentVersion->created, 'dd-MMM-yy HH:mm') ?></td>
        <td><?= $this->Time->format($documentVersion->modified, 'dd-MMM-yy HH:mm') ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
