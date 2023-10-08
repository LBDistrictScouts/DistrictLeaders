<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Audits Controller
 *
 * @property \App\Model\Table\AuditsTable $Audits
 * @method \App\Model\Entity\Audit[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
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
     * @return void
     */
    public function index(): void
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
     * @param string|null $auditId Audit id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $auditId = null): void
    {
        $audit = $this->Audits->get($auditId);

        $this->redirect(['controller' => $audit->audit_table, 'action' => 'view', $audit->audit_record_id]);
    }
}
