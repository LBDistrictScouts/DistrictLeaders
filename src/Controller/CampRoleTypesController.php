<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\CampRoleType;
use Cake\Datasource\ResultSetInterface;

/**
 * CampRoleTypes Controller
 *
 * @property \App\Model\Table\CampRoleTypesTable $CampRoleTypes
 *
 * @method \App\Model\Entity\CampRoleType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CampRoleTypesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $campRoleTypes = $this->paginate($this->CampRoleTypes);

        $this->set(compact('campRoleTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Camp Role Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $campRoleType = $this->CampRoleTypes->get($id, [
            'contain' => ['CampRoles'],
        ]);

        $this->set('campRoleType', $campRoleType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $campRoleType = $this->CampRoleTypes->newEntity();
        if ($this->request->is('post')) {
            $campRoleType = $this->CampRoleTypes->patchEntity($campRoleType, $this->request->getData());
            if ($this->CampRoleTypes->save($campRoleType)) {
                $this->Flash->success(__('The camp role type has been saved.'));

                return $this->redirect(['action' => 'view', $campRoleType->get('id')]);
            }
            $this->Flash->error(__('The camp role type could not be saved. Please, try again.'));
        }
        $this->set(compact('campRoleType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Camp Role Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $campRoleType = $this->CampRoleTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $campRoleType = $this->CampRoleTypes->patchEntity($campRoleType, $this->request->getData());
            if ($this->CampRoleTypes->save($campRoleType)) {
                $this->Flash->success(__('The camp role type has been saved.'));

                return $this->redirect(['action' => 'view', $campRoleType->get('id')]);
            }
            $this->Flash->error(__('The camp role type could not be saved. Please, try again.'));
        }
        $this->set(compact('campRoleType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Camp Role Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $campRoleType = $this->CampRoleTypes->get($id);
        if ($this->CampRoleTypes->delete($campRoleType)) {
            $this->Flash->success(__('The camp role type has been deleted.'));
        } else {
            $this->Flash->error(__('The camp role type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
