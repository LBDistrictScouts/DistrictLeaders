<?php
/**
 * @var AppView $this
 * @var Document[]|CollectionInterface $documents
 * @var User $authUser
 */

use App\Model\Entity\Document;
use App\Model\Entity\User;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$authUser = $this->getRequest()->getAttribute('identity');

$this->extend('../layout/CRUD/search');

$this->assign('entity', 'Documents');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('ADD_DOCUMENT'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('document') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('document_type_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($documents as $document) : ?>
    <tr>
        <td><?= h($document->document) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_DOCUMENT') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $document->id], ['title' => __('View Document'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('EDIT_DOCUMENT') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $document->id], ['title' => __('Edit Document'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_DOCUMENT') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id), 'title' => __('Delete Document'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $document->has('document_type') ? $this->Html->link($document->document_type->document_type, ['controller' => 'DocumentTypes', 'action' => 'view', $document->document_type->id]) : '' ?></td>
        <td><?= $this->Time->format($document->created, 'dd-MMM-yy HH:mm') ?></td>
        <td><?= $this->Time->format($document->modified, 'dd-MMM-yy HH:mm') ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
