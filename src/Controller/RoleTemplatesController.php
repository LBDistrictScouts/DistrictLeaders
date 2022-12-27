<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\RoleTemplate;
use App\Model\Table\RoleTemplatesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * RoleTemplates Controller
 *
 * @property RoleTemplatesTable $RoleTemplates
 * @method RoleTemplate[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoleTemplatesController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $roleTemplates = $this->paginate($this->RoleTemplates);

        $this->set(compact('roleTemplates'));
    }

    /**
     * View method
     *
     * @param string|null $templateId Role Template id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($templateId = null)
    {
        $roleTemplate = $this->RoleTemplates->get($templateId, [
            'contain' => ['RoleTypes'],
        ]);

        $this->set('roleTemplate', $roleTemplate);
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $roleTemplate = $this->RoleTemplates->newEmptyEntity();
        if ($this->request->is('post')) {
            $roleTemplate = $this->RoleTemplates->patchEntity($roleTemplate, $this->request->getData());
            if ($this->RoleTemplates->save($roleTemplate)) {
                $this->Flash->success(__('The role template has been saved.'));

                return $this->redirect(['action' => 'view', $roleTemplate->get(RoleTemplate::FIELD_ID)]);
            }
            $this->Flash->error(__('The role template could not be saved. Please, try again.'));
        }
        $capabilities = $this->RoleTemplates->RoleTypes->Capabilities->getSplitLists();
        $this->set(compact('roleTemplate', 'capabilities'));
    }

    /**
     * Edit method
     *
     * @param string|null $templateId Role Template id.
     * @return Response|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($templateId = null)
    {
        $roleTemplate = $this->RoleTemplates->get($templateId, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $roleTemplate = $this->RoleTemplates->patchEntity($roleTemplate, $this->request->getData());
            if ($this->RoleTemplates->save($roleTemplate)) {
                $this->Flash->success(__('The role template has been saved.'));

                return $this->redirect(['action' => 'view', $roleTemplate->get(RoleTemplate::FIELD_ID)]);
            }
            $this->Flash->error(__('The role template could not be saved. Please, try again.'));
        }
        $capabilities = $this->RoleTemplates->RoleTypes->Capabilities->getSplitLists();

        $this->set(compact('roleTemplate', 'capabilities'));
    }

    /**
     * Delete method
     *
     * @param string|null $templateId Role Template id.
     * @return Response|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($templateId = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $roleTemplate = $this->RoleTemplates->get($templateId);
        if ($this->RoleTemplates->delete($roleTemplate)) {
            $this->Flash->success(__('The role template has been deleted.'));
        } else {
            $this->Flash->error(__('The role template could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
