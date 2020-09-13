<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notification[]|\Cake\Collection\CollectionInterface $notifications
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'Notifications');
$this->assign('subset', 'Your');
$this->assign('add', $this->Identity->checkCapability('CREATE_NOTIFICATION'));

$index = true;

?>
<?= $this->element('notification-list', compact('notifications', 'index'));
