<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\CampType;
use Cake\Datasource\ResultSetInterface;

/**
 * CampTypes Controller
 *
 * @property \App\Model\Table\CampTypesTable $CampTypes
 *
 * @method \App\Model\Entity\CampType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CampTypesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $campTypes = $this->paginate($this->CampTypes);

        $this->set(compact('campTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Camp Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $campType = $this->CampTypes->get($id, [
            'contain' => ['Camps']
        ]);

        $this->set('campType', $campType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $campType = $this->CampTypes->newEntity();
        if ($this->request->is('post')) {
            $campType = $this->CampTypes->patchEntity($campType, $this->request->getData());
            if ($this->CampTypes->save($campType)) {
                $this->Flash->success(__('The camp type has been saved.'));

                return $this->redirect(['action' => 'view', $campType->get('id')]);
            }
            $this->Flash->error(__('The camp type could not be saved. Please, try again.'));
        }
        $this->set(compact('campType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Camp Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $campType = $this->CampTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $campType = $this->CampTypes->patchEntity($campType, $this->request->getData());
            if ($this->CampTypes->save($campType)) {
                $this->Flash->success(__('The camp type has been saved.'));

                return $this->redirect(['action' => 'view', $campType->get('id')]);
            }
            $this->Flash->error(__('The camp type could not be saved. Please, try again.'));
        }
        $this->set(compact('campType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Camp Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $campType = $this->CampTypes->get($id);
        if ($this->CampTypes->delete($campType)) {
            $this->Flash->success(__('The camp type has been deleted.'));
        } else {
            $this->Flash->error(__('The camp type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
