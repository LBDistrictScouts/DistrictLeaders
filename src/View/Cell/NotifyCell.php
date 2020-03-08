<?php
declare(strict_types=1);

namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Notify cell
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\NotificationsTable $Notifications
 */
class NotifyCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadModel('Users');
        $this->loadModel('Notifications');
    }

    /**
     * Default display method.
     *
     * @param int $loggedInUserId The Id of the Authenticated User
     *
     * @return void
     */
    public function display($loggedInUserId)
    {
        if (is_integer($loggedInUserId)) {
            $notifications = $this->Notifications->find('all');

            $name = $this->Users->get($loggedInUserId)->full_name;
            $capabilities = $this->Users->retrieveCapabilities($this->Users->get($loggedInUserId));

            $this->set(compact('capabilities', 'loggedInUserId', 'name', 'notifications'));
        }
    }
}
