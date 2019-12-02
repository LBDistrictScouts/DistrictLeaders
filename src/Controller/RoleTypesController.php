<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\RoleType;
use Cake\Datasource\ResultSetInterface;

/**
 * RoleTypes Controller
 *
 * @property \App\Model\Table\RoleTypesTable $RoleTypes
 *
 * @method RoleType[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoleTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SectionTypes']
        ];
        $roleTypes = $this->paginate($this->RoleTypes);

        $this->set(compact('roleTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Role Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $roleType = $this->RoleTypes->get($id, [
            'contain' => ['SectionTypes', 'Capabilities', 'Roles']
        ]);

        $this->set('roleType', $roleType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $roleType = $this->RoleTypes->newEntity();
        if ($this->request->is('post')) {
            $roleType = $this->RoleTypes->patchEntity($roleType, $this->request->getData());
            if ($this->RoleTypes->save($roleType)) {
                $this->Flash->success(__('The role type has been saved.'));

                return $this->redirect(['action' => 'view', $roleType->id]);
            }
            $this->Flash->error(__('The role type could not be saved. Please, try again.'));
        }
        $sectionTypes = $this->RoleTypes->SectionTypes->find('list', ['limit' => 200]);
        $roleTemplates = $this->RoleTypes->RoleTemplates->find('list', ['limit' => 200]);
        $capabilities = $this->RoleTypes->Capabilities->find('list', ['conditions' => ['min_level <=' => $roleType->level]]);
        $this->set(compact('roleType', 'sectionTypes', 'capabilities', 'roleTemplates'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Role Type id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roleType = $this->RoleTypes->get($id, [
            'contain' => ['Capabilities']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $roleType = $this->RoleTypes->patchEntity($roleType, $this->request->getData());
            if ($this->RoleTypes->save($roleType)) {
                $this->Flash->success(__('The role type has been saved.'));

                return $this->redirect(['action' => 'view', $roleType->id]);
            }
            $this->Flash->error(__('The role type could not be saved. Please, try again.'));
        }
        $sectionTypes = $this->RoleTypes->SectionTypes->find('list', ['limit' => 200]);
        $roleTemplates = $this->RoleTypes->RoleTemplates->find('list', ['limit' => 200]);
        $capabilities = $this->RoleTypes->Capabilities->find('list', ['conditions' => ['min_level <=' => $roleType->level]]);
        $this->set(compact('roleType', 'sectionTypes', 'capabilities', 'roleTemplates'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role Type id.
     * @return \Cake\Http\Response|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $roleType = $this->RoleTypes->get($id);
        if ($this->RoleTypes->delete($roleType)) {
            $this->Flash->success(__('The role type has been deleted.'));
        } else {
            $this->Flash->error(__('The role type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
