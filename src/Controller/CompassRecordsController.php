<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\CompassRecord;
use App\Model\Filter\CompassRecordsCollection;
use App\Model\Table\CompassRecordsTable;
use App\Model\Table\UsersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * CompassRecords Controller
 *
 * @property CompassRecordsTable $CompassRecords
 * @property UsersTable $Users
 * @method CompassRecord[]|ResultSetInterface paginate($object = null, array $settings = [])
 */

class CompassRecordsController extends AppController
{
    /**
     * Index method
     *
     * @param int|null $documentVersionId The ID of the Document Version for Limiting
     * @return Response|void
     */
    public function index($documentVersionId = null)
    {
        $this->paginate = [
            'contain' => ['DocumentVersions.Documents'],
        ];
        $query = $this->CompassRecords->find();
        if (!empty($documentVersionId)) {
            $query = $query->where([CompassRecord::FIELD_DOCUMENT_VERSION_ID => $documentVersionId]);
        }
        $compassRecords = $this->paginate($query);

        $this->set(compact('compassRecords'));
    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function search()
    {
        $this->paginate = [
            'contain' => ['DocumentVersions.Documents'],
        ];
        $query = $this->CompassRecords->find('search', [
            'search' => $this->getRequest()->getQueryParams(),
            'collection' => CompassRecordsCollection::class,
        ]);
        $compassRecords = $this->paginate($query, ['queryStringWhitelist' => ['q']]);

        $this->set(compact('compassRecords'));
    }

    /**
     * View method
     *
     * @param null $recordId Compass Record id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($recordId = null)
    {
        $compassRecord = $this->CompassRecords->get($recordId, [
            'contain' => ['DocumentVersions.Documents'],
        ]);

        $user = $this->CompassRecords->detectUser($compassRecord);
        $mergeStatus = $this->CompassRecords->shouldMerge($compassRecord);

        $this->set(compact('compassRecord', 'user', 'mergeStatus'));
    }

    /**
     * Add method
     *
     * @param int $recordId Compass Record ID for editing
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function edit($recordId)
    {
        $compassRecord = $this->CompassRecords->get($recordId, [
            'contain' => ['DocumentVersions.Documents'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $compassRecord = $this->CompassRecords->patchEntity($compassRecord, $this->request->getData());
            if ($this->CompassRecords->save($compassRecord)) {
                $this->Flash->success(__('The compass record has been saved.'));

                return $this->redirect(['action' => 'view', $compassRecord->get(CompassRecord::FIELD_ID)]);
            }
            $this->Flash->error(__('The compass record could not be saved. Please, try again.'));
        }
        $this->set(compact('compassRecord'));
    }

    /**
     * Add method
     *
     * @param int $compassRecordId The ID of the Directory User
     * @param int $userId The ID of the User
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function merge($compassRecordId, $userId)
    {
        $this->loadModel('Users');

        $compassRecord = $this->CompassRecords->get((int)$compassRecordId);
        $user = $this->Users->get((int)$userId);

        $this->CompassRecords->mergeUser($compassRecord, $user);

        $this->redirect(['controller' => 'Users', 'action' => 'view', $user->id]);
    }

    /**
     * Edit method
     *
     * @param string|null $recordId Compass Record id.
     * @return Response|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function consume($recordId = null)
    {
        $compassRecord = $this->CompassRecords->get($recordId);
        if ($this->request->is(['post'])) {
            if ($this->CompassRecords->importUser($compassRecord)) {
                $this->Flash->success(__('The compass record has been imported.'));
            } else {
                $this->Flash->error(__('The compass record could not be imported. Please, try again.'));
            }
        }

        return $this->redirect(['controll er' => 'CompassRecords', 'action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $recordId Compass Record id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
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
