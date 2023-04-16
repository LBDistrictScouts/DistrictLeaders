<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\DocumentVersion;
use Cake\Utility\Inflector;

/**
 * DocumentVersions Controller
 *
 * @property \App\Model\Table\DocumentVersionsTable $DocumentVersions
 * @property \App\Controller\Component\QueueComponent $Queue
 * @method \App\Model\Entity\DocumentVersion[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentVersionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(): ?Response
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
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $documentVersionId = null): ?Response
    {
        $documentVersion = $this->DocumentVersions->get($documentVersionId, [
            'contain' => ['Documents', 'DocumentEditions'],
        ]);

        $this->set('documentVersion', $documentVersion);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
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
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $documentVersionId = null): ?Response
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
     * @return \Cake\Http\Response|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $documentVersionId = null): ?Response
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
     * @return \Cake\Http\Response|void Redirects to index.
     */
    public function compass(?string $documentVersionId = null): ?Response
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
     * @return \Cake\Http\Response|void Redirects to index.
     * @throws \Exception
     */
    public function autoMerge(?string $documentVersionId = null): ?Response
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
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function map(?string $documentVersionId = null): ?Response
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
