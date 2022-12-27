<?php
/**
 * @var AppView $this
 * @var Notification[]|CollectionInterface $notifications
 */

use App\Model\Entity\Notification;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'Notifications');
$this->assign('subset', 'Your');
$this->assign('add', $this->Identity->checkCapability('CREATE_NOTIFICATION'));

$index = true;

?>
<?= $this->element('notification-list', compact('notifications', 'index'));
