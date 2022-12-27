<?php

declare(strict_types=1);

namespace App\View\Cell;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\View\Cell;

/**
 * NavBar cell
 *
 * @property UsersTable $Users
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
    public function initialize(): void
    {
    }

    /**
     * Default display method.
     *
     * @param User $identity The Authenticated User
     * @return void
     */
    public function display($identity)
    {
        $this->set(compact('identity'));
    }
}
