<?php
/**
 * @var AppView $this
 * @var DocumentEdition[]|CollectionInterface $documentEditions
 * @var User $authUser
 */

use App\Model\Entity\DocumentEdition;
use App\Model\Entity\User;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$authUser = $this->getRequest()->getAttribute('identity');

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'DocumentEditions');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_DOCUMENT_EDITION'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('document_version_id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('file_type_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('size') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('filename') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($documentEditions as $documentEdition) : ?>
    <tr>
        <td><?= $documentEdition->has('document_version') ? $this->Html->link($documentEdition->document_version->document->document . ' (' . $this->Number->format($documentEdition->document_version->version_number) . ')', ['controller' => 'DocumentVersions', 'action' => 'view', $documentEdition->document_version->id]) : '' ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_DOCUMENT_EDITION') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $documentEdition->id], ['title' => __('View Document Edition'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('VIEW_DOCUMENT_EDITION') ? $this->Html->link('<i class="fal fa-download"></i>', ['action' => 'download', $documentEdition->id], ['title' => __('Download Document Edition'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_DOCUMENT_EDITION') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $documentEdition->id], ['title' => __('Edit Document Edition'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_DOCUMENT_EDITION') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $documentEdition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentEdition->id), 'title' => __('Delete Document Edition'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $documentEdition->has('file_type') ? $this->Html->link($documentEdition->file_type->file_type, ['controller' => 'FileTypes', 'action' => 'view', $documentEdition->file_type->id]) : '' ?></td>
        <td><?= $this->Number->toReadableSize($documentEdition->size) ?></td>
        <td><?= $this->Time->format($documentEdition->created, 'dd-MMM-yy HH:mm') ?></td>
        <td><?= h($documentEdition->filename) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
