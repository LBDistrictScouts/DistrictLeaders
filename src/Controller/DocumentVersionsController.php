<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Component\QueueComponent;
use App\Model\Entity\DocumentVersion;
use App\Model\Table\DocumentVersionsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\Utility\Inflector;
use Exception;

/**
 * DocumentVersions Controller
 *
 * @property DocumentVersionsTable $DocumentVersions
 * @property QueueComponent $Queue
 * @method DocumentVersion[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentVersionsController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [
                'Documents.DocumentTypes',
                'DocumentEditions.FileTypes',
            ],
        ];
        $documentVersions = $this->paginate($this->DocumentVersions);

        $this->set(compact('documentVersions'));
    }

    /**
     * View method
     *
     * @param string|null $documentVersionId Document Version id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($documentVersionId = null)
    {
        $documentVersion = $this->DocumentVersions->get($documentVersionId, [
            'contain' => ['Documents', 'DocumentEditions'],
        ]);

        $this->set('documentVersion', $documentVersion);
    }

    /**
     * Add method
     *
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $documentVersion = $this->DocumentVersions->newEmptyEntity();
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
     * @param string|null $documentVersionId Document Version id.
     * @return Response|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($documentVersionId = null)
    {
        $documentVersion = $this->DocumentVersions->get($documentVersionId, [
            'contain' => [],
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
     * @param string|null $documentVersionId Document Version id.
     * @return Response|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($documentVersionId = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $documentVersion = $this->DocumentVersions->get($documentVersionId);
        if ($this->DocumentVersions->delete($documentVersion)) {
            $this->Flash->success(__('The document version has been deleted.'));
        } else {
            $this->Flash->error(__('The document version could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $documentVersionId Document Version id.
     * @return Response|void Redirects to index.
     */
    public function compass($documentVersionId = null)
    {
        $this->request->allowMethod(['post']);
        $documentVersion = $this->DocumentVersions->get($documentVersionId);

        $this->loadComponent('Queue');
        $this->Queue->setCompassVersionImport($documentVersion);

        return $this->redirect(['controller' => 'CompassRecords', 'action' => 'index', $documentVersionId]);
    }

    /**
     * Auto Merge method
     *
     * @param string|null $documentVersionId Document Version id.
     * @return Response|void Redirects to index.
     * @throws Exception
     */
    public function autoMerge($documentVersionId = null)
    {
        $this->request->allowMethod(['post']);
        $documentVersion = $this->DocumentVersions->get($documentVersionId);

        $this->loadComponent('Queue');
        $this->Queue->setCompassAutoMerge($documentVersion);

        return $this->redirect(['controller' => 'CompassRecords', 'action' => 'index', $documentVersionId]);
    }

    /**
     * Add method
     *
     * @param string|null $documentVersionId Document Edition id.
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function map($documentVersionId = null)
    {
        $documentVersion = $this->DocumentVersions->get($documentVersionId);
        $result = $this->DocumentVersions->mapCompassRecords($documentVersion);

        if ($this->request->is('post')) {
            $mapping = $this->request->getData();
            $versionMap = [];

            foreach ($mapping as $fieldKey => $mappedAttribute) {
                $key = (int)str_replace('field', '', $fieldKey);
                if (empty($mappedAttribute)) {
                    $mappedAttribute = $result['fields'][$key];
                }
                $versionMap[$key] = $mappedAttribute;
            }
            $result['mapped'] = $versionMap;
            unset($result['data']);

            $documentVersion->set(DocumentVersion::FIELD_FIELD_MAPPING, $result);
            if ($this->DocumentVersions->save($documentVersion)) {
                $this->Flash->success('Field mappings saved successfully.');
                $this->redirect(['controller' => 'Documents', 'action' => 'view', $documentVersion->document_id]);
            } else {
                $this->Flash->error('Field mappings not saved.');
            }
        }

        $recentEntity = $this->DocumentVersions->CompassRecords->find()->first();
        $fieldList = [];

        foreach ($recentEntity->getAccessible() as $field => $isAccessible) {
            $fieldList[$field] = ucwords(Inflector::humanize($field));
        }
        foreach ($recentEntity->getVisible() as $field) {
            $fieldList[$field] = ucwords(Inflector::humanize($field));
        }
        foreach ($recentEntity->getVirtual() as $virtualField) {
            unset($fieldList[$virtualField]);
        }
        unset($fieldList['document_version_id']);
        unset($fieldList['document_version']);
        unset($fieldList['id']);

        $this->set('fieldMap', $result);
        $this->set(compact('documentVersion', 'recentEntity', 'fieldList'));
    }
}
