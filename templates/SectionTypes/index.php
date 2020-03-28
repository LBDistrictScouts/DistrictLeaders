<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SectionType[]|\Cake\Collection\CollectionInterface $sectionTypes
 * @var \App\Model\Entity\User $authUser
 */

$authUser = $this->getRequest()->getAttribute('identity');

$this->extend('../Layout/CRUD/index');

$this->assign('entity', 'SectionTypes');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_SECTION_TYPE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('section_type') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($sectionTypes as $sectionType): ?>
    <tr>
        <td><?= h($sectionType->section_type) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_SECTION_TYPE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $sectionType->id], ['title' => __('View Section Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_SECTION_TYPE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $sectionType->id], ['title' => __('Edit Section Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_SECTION_TYPE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $sectionType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sectionType->id), 'title' => __('Delete Section Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
