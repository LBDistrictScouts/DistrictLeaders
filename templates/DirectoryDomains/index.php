<?php
/**
 * @var AppView $this
 * @var DirectoryDomain[]|CollectionInterface $directoryDomains
 */

use App\Model\Entity\DirectoryDomain;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'DirectoryDomains');
$this->assign('subset', 'All');

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_domain') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('ingest') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($directoryDomains as $directoryDomain) : ?>
    <tr>
        <td><?= h($directoryDomain->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_DIRECTORY_DOMAIN') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $directoryDomain->id], ['title' => __('View Directory Domain'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_DIRECTORY_DOMAIN') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $directoryDomain->id], ['title' => __('Edit Directory Domain'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_DIRECTORY_DOMAIN') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $directoryDomain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryDomain->id), 'title' => __('Delete Directory Domain'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($directoryDomain->directory_domain) ?></td>
        <td><?= $directoryDomain->has($directoryDomain::FIELD_DIRECTORY) ? $this->Html->link($directoryDomain->directory->directory, ['controller' => 'Directories', 'action' => 'view', $directoryDomain->directory->id]) : '' ?></td>
        <td><?= $this->Icon->iconBoolean($directoryDomain->ingest) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
