<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document[]|\Cake\Collection\CollectionInterface $documents
 * @var \App\Model\Entity\User $authUser
 */

$authUser = $this->request->getAttribute('identity');

$this->extend('../Layout/CRUD/index');

$this->assign('entity', 'Documents');
$this->assign('subset', 'All');
$this->assign('add', $authUser->checkCapability('ADD_DOCS'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('document') ?></th>
        <th scope="col"><?= $this->Paginator->sort('document_type_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($documents as $document): ?>
    <tr>
        <td><?= h($document->document) ?></td>
        <td><?= $document->has('document_type') ? $this->Html->link($document->document_type->document_type, ['controller' => 'DocumentTypes', 'action' => 'view', $document->document_type->id]) : '' ?></td>
        <td><?= $this->Time->format($document->created, 'dd-MMM-yy HH:mm') ?></td>
        <td class="actions">
            <?= $this->Html->link(__('View'), ['action' => 'view', $document->id]) ?>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $document->id]) ?>
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
