<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Profile cell
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class ProfileCell extends Cell
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
        $this->loadModel('Users');

        $name = $this->Users->get($loggedInUserId)->full_name;
        $capabilities = $this->Users->retrieveCapabilities($this->Users->get($loggedInUserId));

        $this->set(compact('capabilities', 'loggedInUserId', 'name'));
    }
}
