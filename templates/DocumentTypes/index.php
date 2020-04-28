<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentType[]|\Cake\Collection\CollectionInterface $documentTypes
 * @var \App\Model\Entity\User $authUser
 */

$authUser = $this->request->getAttribute('identity');

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'DocumentTypes');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CH_DOCTYPE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('document_type') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($documentTypes as $documentType) : ?>
    <tr>
        <td><?= $this->Number->format($documentType->id) ?></td>
        <td><?= h($documentType->document_type) ?></td>
        <td class="actions">
            <?= $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $documentType->id], ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
            <?= $this->Identity->checkCapability('CH_DOCTYPE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $documentType->id], ['title' => __('Edit'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('CH_DOCTYPE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $documentType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentType->id), 'title' => __('Delete'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
