<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RoleTypes Controller
 *
 * @property \App\Model\Table\RoleTypesTable $RoleTypes
 *
 * @method \App\Model\Entity\RoleType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
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
            'contain' => ['SectionTypes', 'Roles']
        ]);

        $this->set('roleType', $roleType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $roleType = $this->RoleTypes->newEntity();
        if ($this->request->is('post')) {
            $roleType = $this->RoleTypes->patchEntity($roleType, $this->request->getData());
            if ($this->RoleTypes->save($roleType)) {
                $this->Flash->success(__('The role type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The role type could not be saved. Please, try again.'));
        }
        $sectionTypes = $this->RoleTypes->SectionTypes->find('list', ['limit' => 200]);
        $this->set(compact('roleType', 'sectionTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Role Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roleType = $this->RoleTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $roleType = $this->RoleTypes->patchEntity($roleType, $this->request->getData());
            if ($this->RoleTypes->save($roleType)) {
                $this->Flash->success(__('The role type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The role type could not be saved. Please, try again.'));
        }
        $sectionTypes = $this->RoleTypes->SectionTypes->find('list', ['limit' => 200]);
        $this->set(compact('roleType', 'sectionTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role Type id.
     * @return \Cake\Http\Response|null Redirects to index.
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
