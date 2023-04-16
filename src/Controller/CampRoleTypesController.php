<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CampRoleTypes Controller
 *
 * @property \App\Model\Table\CampRoleTypesTable $CampRoleTypes
 * @method \App\Model\Entity\CampRoleType[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CampRoleTypesController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $campRoleTypes = $this->paginate($this->CampRoleTypes);

        $this->set(compact('campRoleTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Camp Role Type id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): void
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
    public function add(): void
    {
        $campRoleType = $this->CampRoleTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $campRoleType = $this->CampRoleTypes->patchEntity($campRoleType, $this->request->getData());
            if ($this->CampRoleTypes->save($campRoleType)) {
                $this->Flash->success(__('The camp role type has been saved.'));

                $this->redirect(['action' => 'view', $campRoleType->get('id')]);
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
    public function edit(?string $id = null): void
    {
        $campRoleType = $this->CampRoleTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $campRoleType = $this->CampRoleTypes->patchEntity($campRoleType, $this->request->getData());
            if ($this->CampRoleTypes->save($campRoleType)) {
                $this->Flash->success(__('The camp role type has been saved.'));

                $this->redirect(['action' => 'view', $campRoleType->get('id')]);
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
    public function delete(?string $id = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $campRoleType = $this->CampRoleTypes->get($id);
        if ($this->CampRoleTypes->delete($campRoleType)) {
            $this->Flash->success(__('The camp role type has been deleted.'));
        } else {
            $this->Flash->error(__('The camp role type could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }
}
