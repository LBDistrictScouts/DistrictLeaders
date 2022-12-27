<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;
use Cake\ORM\Table;

/**
 * Admin Controller
 *
 * @property Table $Admin
 */
class AdminController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
    }

    /**
     * Status method
     *
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function status()
    {
    }
}
