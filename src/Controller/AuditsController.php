<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Audits Controller
 *
 * @property \App\Model\Table\AuditsTable $Audits
 * @method \App\Model\Entity\Audit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AuditsController extends AppController
{
    /**
     * @throws \Exception
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
