<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Audit;
use Cake\Datasource\ResultSetInterface;

/**
 * Audits Controller
 *
 * @property \App\Model\Table\AuditsTable $Audits
 *
 * @method Audit[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class AuditsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
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
     * @return \Cake\Http\Response
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $audit = $this->Audits->get($id);

        return $this->redirect(['controller' => $audit->audit_table, 'action' => 'view', $audit->audit_record_id]);
    }
}
