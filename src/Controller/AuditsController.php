<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Audit;
use App\Model\Table\AuditsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Exception;

/**
 * Audits Controller
 *
 * @property AuditsTable $Audits
 * @method Audit[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class AuditsController extends AppController
{
    /**
     * @throws Exception
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->whyPermitted($this->Audits);
    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'ChangedUsers'],
        ];
        $audits = $this->paginate($this->Audits);

        $this->set(compact('audits'));
    }

    /**
     * View method
     *
     * @param string|null $id Audit id.
     * @return Response
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $audit = $this->Audits->get($id);

        return $this->redirect(['controller' => $audit->audit_table, 'action' => 'view', $audit->audit_record_id]);
    }
}
