<?php
/**
 * @var AppView $this
 * @var DirectoryGroup[]|CollectionInterface $directoryGroups
 */

use App\Model\Entity\DirectoryGroup;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'DirectoryGroups');
$this->assign('subset', 'All');

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('directory_group_name') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_group_email') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($directoryGroups as $directoryGroup) : ?>
    <tr>
        <td><?= h($directoryGroup->directory_group_name) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_DIRECTORY_GROUP') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $directoryGroup->id], ['title' => __('View Directory Group'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_DIRECTORY_GROUP') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $directoryGroup->id], ['title' => __('Edit Directory Group'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_DIRECTORY_GROUP') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $directoryGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryGroup->id), 'title' => __('Delete Directory Group'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $directoryGroup->has($directoryGroup::FIELD_DIRECTORY) ? $this->Html->link($directoryGroup->directory->directory, ['controller' => 'Directories', 'action' => 'view', $directoryGroup->directory->id]) : '' ?></td>
        <td><?= h($directoryGroup->directory_group_email) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
