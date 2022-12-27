<?php

declare(strict_types=1);

namespace App\View\Cell;

use App\Model\Table\UsersTable;
use Cake\View\Cell;

/**
 * Profile cell
 *
 * @property UsersTable $Users
 */
class ProfileModalCell extends Cell
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
    public function initialize(): void
    {
    }

    /**
     * Default display method.
     *
     * @param int $loggedInUserId The Id of the Authenticated User
     * @return void
     */
    public function display($loggedInUserId)
    {
        if (is_integer($loggedInUserId)) {
            $this->loadModel('Users');

            $name = $this->Users->get($loggedInUserId)->full_name;
            $capabilities = $this->Users->retrieveCapabilities($this->Users->get($loggedInUserId));

            $this->set(compact('capabilities', 'loggedInUserId', 'name'));
        }
    }
}
