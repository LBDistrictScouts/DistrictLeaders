<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\CampType;
use App\Model\Table\CampTypesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * CampTypes Controller
 *
 * @property CampTypesTable $CampTypes
 * @method CampType[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class CampTypesController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
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
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $campType = $this->CampTypes->get($id, [
            'contain' => ['Camps'],
        ]);

        $this->set('campType', $campType);
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $campType = $this->CampTypes->newEmptyEntity();
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
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $campType = $this->CampTypes->get($id, [
            'contain' => [],
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
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
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
