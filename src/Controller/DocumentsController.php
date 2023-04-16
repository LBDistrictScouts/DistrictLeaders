<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Document;
use App\Model\Entity\DocumentType;
use App\Model\Filter\DocumentsCollection;
use Cake\Utility\Inflector;
use Exception;

/**
 * Documents Controller
 *
 * @property \App\Model\Table\DocumentsTable $Documents
 *
 * @property \App\Controller\Component\FilterComponent $Filter
 * @method \App\Model\Entity\Document[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 * @property \Search\Controller\Component\SearchComponent $Search
 */
class DocumentsController extends AppController
{
    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Search.Search', [
            // This is default config. You can modify "actions" as needed to make
            // the SEARCH component work only for specified methods.
            'actions' => ['search'],
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(): ?Response
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
    public function search(): ?Response
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
     * @param string|null $documentId Document id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $documentId = null): ?Response
    {
        $document = $this->Documents->get($documentId, [
            'contain' => ['DocumentTypes', 'DocumentVersions.DocumentEditions.FileTypes', 'DocumentPreviews'],
        ]);

        $this->set('document', $document);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
    {
        /** @var \App\Model\Entity\Document $document */
        $document = $this->Documents->newEmptyEntity();
        $this->Documents->DocumentVersions->DocumentEditions->FileTypes->installBaseFileTypes();

        if (key_exists('document_type', $this->request->getQueryParams())) {
            $documentType = $this->request->getQueryParams()['document_type'];
            $documentType = ucwords(Inflector::humanize($documentType));

            /** @var \App\Model\Entity\DocumentType $documentType */
            $documentType = $this->Documents->DocumentTypes->find()
                ->where([DocumentType::FIELD_DOCUMENT_TYPE => $documentType])->firstOrFail();
            $term = $documentType->get(DocumentType::FIELD_DOCUMENT_TYPE);
            $this->set(compact('term', 'documentType'));

            $document->set(
                Document::FIELD_DOCUMENT_TYPE_ID,
                $documentType->get(DocumentType::FIELD_ID)
            );
        }

        if ($this->getRequest()->is('post')) {
            $data = $this->getRequest()->getData();
            if (isset($documentType)) {
                $data[Document::FIELD_DOCUMENT_TYPE_ID] = $documentType->id;
            }
            $document = $this->Documents->uploadDocument($data, $document);
            if ($document instanceof Document) {
                $this->Flash->success(__('The document has been saved.'));

                return $this->redirect(['action' => 'view', $document->get(Document::FIELD_ID)]);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
        }
        $this->set(compact('document'));

        if (!isset($documentType)) {
            $documentTypes = $this->Documents->DocumentTypes->find('list', ['limit' => 200]);
            $term = 'Document Type';
            $this->set(compact('documentTypes', 'term'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $documentId Document id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $documentId = null): ?Response
    {
        $document = $this->Documents->get($documentId, [
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
     * @param string|null $documentId Document id.
     * @return \Cake\Http\Response|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $documentId = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $document = $this->Documents->get($documentId);
        if ($this->Documents->delete($document)) {
            $this->Flash->success(__('The document has been deleted.'));
        } else {
            $this->Flash->error(__('The document could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
