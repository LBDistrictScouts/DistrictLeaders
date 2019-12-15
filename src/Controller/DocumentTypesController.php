<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\DocumentType;
use Cake\Datasource\ResultSetInterface;

/**
 * DocumentTypes Controller
 *
 * @property \App\Model\Table\DocumentTypesTable $DocumentTypes
 *
 * @method \App\Model\Entity\DocumentType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $documentTypes = $this->paginate($this->DocumentTypes);

        $this->set(compact('documentTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Document Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $documentType = $this->DocumentTypes->get($id, [
            'contain' => ['Documents'],
        ]);

        $this->set('documentType', $documentType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $documentType = $this->DocumentTypes->newEntity();
        if ($this->request->is('post')) {
            $documentType = $this->DocumentTypes->patchEntity($documentType, $this->request->getData());
            if ($this->DocumentTypes->save($documentType)) {
                $this->Flash->success(__('The document type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document type could not be saved. Please, try again.'));
        }
        $this->set(compact('documentType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document Type id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $documentType = $this->DocumentTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documentType = $this->DocumentTypes->patchEntity($documentType, $this->request->getData());
            if ($this->DocumentTypes->save($documentType)) {
                $this->Flash->success(__('The document type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document type could not be saved. Please, try again.'));
        }
        $this->set(compact('documentType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document Type id.
     * @return \Cake\Http\Response|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $documentType = $this->DocumentTypes->get($id);
        if ($this->DocumentTypes->delete($documentType)) {
            $this->Flash->success(__('The document type has been deleted.'));
        } else {
            $this->Flash->error(__('The document type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
