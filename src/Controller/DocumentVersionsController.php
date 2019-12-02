<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\DocumentVersion;
use Cake\Datasource\ResultSetInterface;

/**
 * DocumentVersions Controller
 *
 * @property \App\Model\Table\DocumentVersionsTable $DocumentVersions
 *
 * @method DocumentVersion[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentVersionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [
                'Documents.DocumentTypes',
                'DocumentEditions.FileTypes'
            ]
        ];
        $documentVersions = $this->paginate($this->DocumentVersions);

        $this->set(compact('documentVersions'));
    }

    /**
     * View method
     *
     * @param string|null $id Document Version id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $documentVersion = $this->DocumentVersions->get($id, [
            'contain' => ['Documents', 'DocumentEditions']
        ]);

        $this->set('documentVersion', $documentVersion);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $documentVersion = $this->DocumentVersions->newEntity();
        if ($this->request->is('post')) {
            $documentVersion = $this->DocumentVersions->patchEntity($documentVersion, $this->request->getData());
            if ($this->DocumentVersions->save($documentVersion)) {
                $this->Flash->success(__('The document version has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document version could not be saved. Please, try again.'));
        }
        $documents = $this->DocumentVersions->Documents->find('list', ['limit' => 200]);
        $this->set(compact('documentVersion', 'documents'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document Version id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $documentVersion = $this->DocumentVersions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documentVersion = $this->DocumentVersions->patchEntity($documentVersion, $this->request->getData());
            if ($this->DocumentVersions->save($documentVersion)) {
                $this->Flash->success(__('The document version has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document version could not be saved. Please, try again.'));
        }
        $documents = $this->DocumentVersions->Documents->find('list', ['limit' => 200]);
        $this->set(compact('documentVersion', 'documents'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document Version id.
     * @return \Cake\Http\Response|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $documentVersion = $this->DocumentVersions->get($id);
        if ($this->DocumentVersions->delete($documentVersion)) {
            $this->Flash->success(__('The document version has been deleted.'));
        } else {
            $this->Flash->error(__('The document version could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
