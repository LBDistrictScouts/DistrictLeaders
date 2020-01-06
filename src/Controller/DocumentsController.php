<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Document;
use App\Model\Filter\DocumentsCollection;
use Exception;

/**
 * Documents Controller
 *
 * @property \App\Model\Table\DocumentsTable $Documents
 *
 * @property \App\Controller\Component\FilterComponent $Filter
 *
 * @method \App\Model\Entity\Document[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 * @property \Search\Controller\Component\PrgComponent $Prg
 */
class DocumentsController extends AppController
{
    /**
     * @throws \Exception
     *
     * {@inheritdoc}
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Search.Prg', [
            // This is default config. You can modify "actions" as needed to make
            // the PRG component work only for specified methods.
            'actions' => ['search'],
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        try {
            $this->loadComponent('Filter');
            $query = $this->Filter->indexFilters(
                $this->Documents->getAssociation('DocumentTypes'),
                $this->getRequest()->getQueryParams()
            );
        } catch (Exception $exception) {
            $query = $this->Documents->find()->contain(['DocumentTypes']);
        }

        $documents = $this->paginate($query);

        $this->set(compact('documents'));
    }

    /**
     * Search method
     *
     * @return \Cake\Http\Response|void
     */
    public function search()
    {
        $this->paginate = [
            'contain' => ['DocumentTypes', 'DocumentVersions.DocumentEditions.FileTypes'],
        ];

        $query = $this->Documents->find('search', [
            'search' => $this->getRequest()->getQueryParams(),
            'collection' => DocumentsCollection::class,
        ]);

        $documents = $this->paginate($query);

        $this->set(compact('documents'));
    }

    /**
     * View method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => ['DocumentTypes', 'DocumentVersions.DocumentEditions.FileTypes'],
        ]);

        $this->set('document', $document);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $document = $this->Documents->newEntity();
        $this->Documents->DocumentVersions->DocumentEditions->FileTypes->installBaseFileTypes();
        if ($this->getRequest()->is('post')) {
            $document = $this->Documents->uploadDocument($this->getRequest()->getData(), $document);
            if ($document instanceof Document) {
                $this->Flash->success(__('The document has been saved.'));

                return $this->redirect(['action' => 'view', $document->get(Document::FIELD_ID)]);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
        }
        $documentTypes = $this->Documents->DocumentTypes->find('list', ['limit' => 200]);
        $this->set(compact('document', 'documentTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $document = $this->Documents->patchEntity($document, $this->request->getData());
            if ($this->Documents->save($document)) {
                $this->Flash->success(__('The document has been saved.'));

                return $this->redirect(['action' => 'view', $document->get(Document::FIELD_ID)]);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
        }
        $documentTypes = $this->Documents->DocumentTypes->find('list', ['limit' => 200]);
        $this->set(compact('document', 'documentTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $document = $this->Documents->get($id);
        if ($this->Documents->delete($document)) {
            $this->Flash->success(__('The document has been deleted.'));
        } else {
            $this->Flash->error(__('The document could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
