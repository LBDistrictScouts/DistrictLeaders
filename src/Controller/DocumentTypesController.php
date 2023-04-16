<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\DocumentType;

/**
 * DocumentTypes Controller
 *
 * @property \App\Model\Table\DocumentTypesTable $DocumentTypes
 * @method \App\Model\Entity\DocumentType[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentTypesController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $documentTypes = $this->paginate($this->DocumentTypes);

        $this->set(compact('documentTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Document Type id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): void
    {
        $documentType = $this->DocumentTypes->get($id, [
            'contain' => ['Documents'],
        ]);

        $this->set('documentType', $documentType);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add(): void
    {
        $documentType = $this->DocumentTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $documentType = $this->DocumentTypes->patchEntity($documentType, $this->request->getData());
            if ($this->DocumentTypes->save($documentType)) {
                $this->Flash->success(__('The document type has been saved.'));

                $this->redirect(['action' => 'view', $documentType->get(DocumentType::FIELD_ID)]);
            }
            $this->Flash->error(__('The document type could not be saved. Please, try again.'));
        }
        $this->set(compact('documentType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): void
    {
        $documentType = $this->DocumentTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documentType = $this->DocumentTypes->patchEntity($documentType, $this->request->getData());
            if ($this->DocumentTypes->save($documentType)) {
                $this->Flash->success(__('The document type has been saved.'));

                $this->redirect(['action' => 'view', $documentType->get(DocumentType::FIELD_ID)]);
            }
            $this->Flash->error(__('The document type could not be saved. Please, try again.'));
        }
        $this->set(compact('documentType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document Type id.
     * @return void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $documentType = $this->DocumentTypes->get($id);
        if ($this->DocumentTypes->delete($documentType)) {
            $this->Flash->success(__('The document type has been deleted.'));
        } else {
            $this->Flash->error(__('The document type could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }
}
