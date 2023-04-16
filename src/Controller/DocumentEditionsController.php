<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\DocumentEdition;
use Josbeir\Filesystem\FilesystemAwareTrait;

/**
 * DocumentEditions Controller
 *
 * @property \App\Model\Table\DocumentEditionsTable $DocumentEditions
 * @method \App\Model\Entity\DocumentEdition[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentEditionsController extends AppController
{
    use FilesystemAwareTrait;

    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $this->paginate = [
            'contain' => ['DocumentVersions.Documents', 'FileTypes'],
        ];
        $documentEditions = $this->paginate($this->DocumentEditions);

        $this->set(compact('documentEditions'));
    }

    /**
     * View method
     *
     * @param string|null $documentEditionId Document Edition id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $documentEditionId = null): void
    {
        $documentEdition = $this->DocumentEditions->get($documentEditionId, [
            'contain' => ['DocumentVersions', 'FileTypes'],
        ]);

        $this->set('documentEdition', $documentEdition);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function upload(): void
    {
        $documentEdition = $this->DocumentEditions->newEmptyEntity();
        if ($this->request->is('post')) {
//            debug($this->request->getData());

            $documentEdition = $this->DocumentEditions->uploadDocument($this->request->getData());

//            debug($documentEdition);

            if ($this->DocumentEditions->save($documentEdition)) {
                $this->Flash->success(__('The document edition has been saved.'));

                $this->redirect(['action' => 'view', $documentEdition->get(DocumentEdition::FIELD_ID)]);
            }
            $this->Flash->error(__('The document edition could not be saved. Please, try again.'));
        }
        $documentVersions = $this->DocumentEditions->DocumentVersions->find('documentList', ['limit' => 200]);
        $fileTypes = $this->DocumentEditions->FileTypes->find('list', ['limit' => 200]);
        $this->set(compact('documentEdition', 'documentVersions', 'fileTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $documentEditionId Document Edition id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $documentEditionId = null): void
    {
        $documentEdition = $this->DocumentEditions->get($documentEditionId, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documentEdition = $this->DocumentEditions->patchEntity($documentEdition, $this->request->getData());
            if ($this->DocumentEditions->save($documentEdition)) {
                $this->Flash->success(__('The document edition has been saved.'));

                $this->redirect(['action' => 'view', $documentEdition->get(DocumentEdition::FIELD_ID)]);
            }
            $this->Flash->error(__('The document edition could not be saved. Please, try again.'));
        }
        $documentVersions = $this->DocumentEditions->DocumentVersions->find('documentList', ['limit' => 200]);
        $fileTypes = $this->DocumentEditions->FileTypes->find('list', ['limit' => 200]);
        $this->set(compact('documentEdition', 'documentVersions', 'fileTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document Edition id.
     * @return void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $documentEdition = $this->DocumentEditions->get($id);
        if ($this->DocumentEditions->delete($documentEdition)) {
            $this->Flash->success(__('The document edition has been deleted.'));
        } else {
            $this->Flash->error(__('The document edition could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }
}
