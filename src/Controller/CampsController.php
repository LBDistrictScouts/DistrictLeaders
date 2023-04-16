<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Camps Controller
 *
 * @property \App\Model\Table\CampsTable $Camps
 * @method \App\Model\Entity\Camp[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CampsController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $this->paginate = [
            'contain' => ['CampTypes'],
        ];
        $camps = $this->paginate($this->Camps);

        $this->set(compact('camps'));
    }

    /**
     * View method
     *
     * @param string|null $id Camp id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): void
    {
        $camp = $this->Camps->get($id, [
            'contain' => ['CampTypes', 'CampRoles'],
        ]);

        $this->set('camp', $camp);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): void
    {
        $camp = $this->Camps->newEmptyEntity();
        if ($this->request->is('post')) {
            $camp = $this->Camps->patchEntity($camp, $this->request->getData());
            if ($this->Camps->save($camp)) {
                $this->Flash->success(__('The camp has been saved.'));

                $this->redirect(['action' => 'view', $camp->get('id')]);
            }
            $this->Flash->error(__('The camp could not be saved. Please, try again.'));
        }
        $campTypes = $this->Camps->CampTypes->find('list', ['limit' => 200]);
        $this->set(compact('camp', 'campTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Camp id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): void
    {
        $camp = $this->Camps->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $camp = $this->Camps->patchEntity($camp, $this->request->getData());
            if ($this->Camps->save($camp)) {
                $this->Flash->success(__('The camp has been saved.'));

                $this->redirect(['action' => 'view', $camp->get('id')]);
            }
            $this->Flash->error(__('The camp could not be saved. Please, try again.'));
        }
        $campTypes = $this->Camps->CampTypes->find('list', ['limit' => 200]);
        $this->set(compact('camp', 'campTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Camp id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $camp = $this->Camps->get($id);
        if ($this->Camps->delete($camp)) {
            $this->Flash->success(__('The camp has been deleted.'));
        } else {
            $this->Flash->error(__('The camp could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }
}
