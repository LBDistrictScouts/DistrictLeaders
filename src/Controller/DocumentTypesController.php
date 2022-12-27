<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\DocumentType;
use App\Model\Table\DocumentTypesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * DocumentTypes Controller
 *
 * @property DocumentTypesTable $DocumentTypes
 * @method DocumentType[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentTypesController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
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
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
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
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $documentType = $this->DocumentTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $documentType = $this->DocumentTypes->patchEntity($documentType, $this->request->getData());
            if ($this->DocumentTypes->save($documentType)) {
                $this->Flash->success(__('The document type has been saved.'));

                return $this->redirect(['action' => 'view', $documentType->get(DocumentType::FIELD_ID)]);
            }
            $this->Flash->error(__('The document type could not be saved. Please, try again.'));
        }
        $this->set(compact('documentType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document Type id.
     * @return Response|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
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

                return $this->redirect(['action' => 'view', $documentType->get(DocumentType::FIELD_ID)]);
            }
            $this->Flash->error(__('The document type could not be saved. Please, try again.'));
        }
        $this->set(compact('documentType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document Type id.
     * @return Response|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
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
