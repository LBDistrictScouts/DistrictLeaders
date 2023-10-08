<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\RoleTemplate;

/**
 * RoleTemplates Controller
 *
 * @property \App\Model\Table\RoleTemplatesTable $RoleTemplates
 * @method \App\Model\Entity\RoleTemplate[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoleTemplatesController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $roleTemplates = $this->paginate($this->RoleTemplates);

        $this->set(compact('roleTemplates'));
    }

    /**
     * View method
     *
     * @param string|null $templateId Role Template id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $templateId = null): void
    {
        $roleTemplate = $this->RoleTemplates->get($templateId, [
            'contain' => ['RoleTypes'],
        ]);

        $this->set('roleTemplate', $roleTemplate);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): void
    {
        $roleTemplate = $this->RoleTemplates->newEmptyEntity();
        if ($this->request->is('post')) {
            $roleTemplate = $this->RoleTemplates->patchEntity($roleTemplate, $this->request->getData());
            if ($this->RoleTemplates->save($roleTemplate)) {
                $this->Flash->success(__('The role template has been saved.'));

                $this->redirect(['action' => 'view', $roleTemplate->get(RoleTemplate::FIELD_ID)]);
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
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $templateId = null): void
    {
        $roleTemplate = $this->RoleTemplates->get($templateId, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $roleTemplate = $this->RoleTemplates->patchEntity($roleTemplate, $this->request->getData());
            if ($this->RoleTemplates->save($roleTemplate)) {
                $this->Flash->success(__('The role template has been saved.'));

                $this->redirect(['action' => 'view', $roleTemplate->get(RoleTemplate::FIELD_ID)]);
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
     * @return void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $templateId = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $roleTemplate = $this->RoleTemplates->get($templateId);
        if ($this->RoleTemplates->delete($roleTemplate)) {
            $this->Flash->success(__('The role template has been deleted.'));
        } else {
            $this->Flash->error(__('The role template could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }
}
