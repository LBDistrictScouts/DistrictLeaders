<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\CompassRecord;

/**
 * CompassRecords Controller
 *
 * @property \App\Model\Table\CompassRecordsTable $CompassRecords
 * @method \App\Model\Entity\CompassRecord[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class CompassRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['DocumentVersions'],
        ];
        $compassRecords = $this->paginate($this->CompassRecords);

        $this->set(compact('compassRecords'));
    }

    /**
     * View method
     *
     * @param null $recordId Compass Record id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($recordId = null)
    {
        $compassRecord = $this->CompassRecords->get($recordId, [
            'contain' => ['DocumentVersions'],
        ]);

        $this->set('compassRecord', $compassRecord);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $compassRecord = $this->CompassRecords->newEmptyEntity();
        if ($this->request->is('post')) {
            $compassRecord = $this->CompassRecords->patchEntity($compassRecord, $this->request->getData());
            if ($this->CompassRecords->save($compassRecord)) {
                $this->Flash->success(__('The compass record has been saved.'));

                return $this->redirect(['action' => 'view', $compassRecord->get(CompassRecord::FIELD_ID)]);
            }
            $this->Flash->error(__('The compass record could not be saved. Please, try again.'));
        }
        $documentVersions = $this->CompassRecords->DocumentVersions->find('list', ['limit' => 200]);
        $this->set(compact('compassRecord', 'documentVersions'));
    }

    /**
     * Edit method
     *
     * @param string|null $recordId Compass Record id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($recordId = null)
    {
        $compassRecord = $this->CompassRecords->get($recordId, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $compassRecord = $this->CompassRecords->patchEntity($compassRecord, $this->request->getData());
            if ($this->CompassRecords->save($compassRecord)) {
                $this->Flash->success(__('The compass record has been saved.'));

                return $this->redirect(['action' => 'view', $compassRecord->get(CompassRecord::FIELD_ID)]);
            }
            $this->Flash->error(__('The compass record could not be saved. Please, try again.'));
        }
        $documentVersions = $this->CompassRecords->DocumentVersions->find('list', ['limit' => 200]);
        $this->set(compact('compassRecord', 'documentVersions'));
    }

    /**
     * Delete method
     *
     * @param string|null $recordId Compass Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $recordId = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $compassRecord = $this->CompassRecords->get($recordId);
        if ($this->CompassRecords->delete($compassRecord)) {
            $this->Flash->success(__('The compass record has been deleted.'));
        } else {
            $this->Flash->error(__('The compass record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}