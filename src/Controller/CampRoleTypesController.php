<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\CampRoleType;
use App\Model\Table\CampRoleTypesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * CampRoleTypes Controller
 *
 * @property CampRoleTypesTable $CampRoleTypes
 * @method CampRoleType[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class CampRoleTypesController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
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
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
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
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $campRoleType = $this->CampRoleTypes->newEmptyEntity();
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
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
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
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
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
