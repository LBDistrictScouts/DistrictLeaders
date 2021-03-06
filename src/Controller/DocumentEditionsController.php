<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\DocumentEdition;
use Josbeir\Filesystem\FilesystemAwareTrait;

/**
 * DocumentEditions Controller
 *
 * @property \App\Model\Table\DocumentEditionsTable $DocumentEditions
 * @method \App\Model\Entity\DocumentEdition[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentEditionsController extends AppController
{
    use FilesystemAwareTrait;

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
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
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($documentEditionId = null)
    {
        $documentEdition = $this->DocumentEditions->get($documentEditionId, [
            'contain' => ['DocumentVersions', 'FileTypes'],
        ]);

        $this->set('documentEdition', $documentEdition);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function upload()
    {
        $documentEdition = $this->DocumentEditions->newEmptyEntity();
        if ($this->request->is('post')) {
//            debug($this->request->getData());

            $documentEdition = $this->DocumentEditions->uploadDocument($this->request->getData());

//            debug($documentEdition);

            if ($this->DocumentEditions->save($documentEdition)) {
                $this->Flash->success(__('The document edition has been saved.'));

                return $this->redirect(['action' => 'view', $documentEdition->get(DocumentEdition::FIELD_ID)]);
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
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($documentEditionId = null)
    {
        $documentEdition = $this->DocumentEditions->get($documentEditionId, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documentEdition = $this->DocumentEditions->patchEntity($documentEdition, $this->request->getData());
            if ($this->DocumentEditions->save($documentEdition)) {
                $this->Flash->success(__('The document edition has been saved.'));

                return $this->redirect(['action' => 'view', $documentEdition->get(DocumentEdition::FIELD_ID)]);
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
     * @return \Cake\Http\Response|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $documentEdition = $this->DocumentEditions->get($id);
        if ($this->DocumentEditions->delete($documentEdition)) {
            $this->Flash->success(__('The document edition has been deleted.'));
        } else {
            $this->Flash->error(__('The document edition could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
