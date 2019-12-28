<?php
declare(strict_types=1);

namespace App\View\Cell;

use Cake\View\Cell;

/**
 * NavBar cell
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class NavBarCell extends Cell
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
     * @param \App\Model\Entity\User $identity The Authenticated User
     *
     * @return void
     */
    public function display($identity)
    {
        $this->set(compact('identity'));
    }
}
