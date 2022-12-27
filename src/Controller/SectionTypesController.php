<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\SectionType;
use App\Model\Table\SectionTypesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * SectionTypes Controller
 *
 * @property SectionTypesTable $SectionTypes
 * @method SectionType[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class SectionTypesController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $sectionTypes = $this->paginate($this->SectionTypes);

        $this->set(compact('sectionTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Section Type id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sectionType = $this->SectionTypes->get($id, [
            'contain' => ['RoleTypes', 'Sections'],
        ]);

        $this->set('sectionType', $sectionType);
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sectionType = $this->SectionTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $sectionType = $this->SectionTypes->patchEntity($sectionType, $this->request->getData());
            if ($this->SectionTypes->save($sectionType)) {
                $this->Flash->success(__('The section type has been saved.'));

                return $this->redirect(['controller' => 'SectionTypes', 'action' => 'view', $sectionType->id]);
            }
            $this->Flash->error(__('The section type could not be saved. Please, try again.'));
        }
        $this->set(compact('sectionType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Section Type id.
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sectionType = $this->SectionTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sectionType = $this->SectionTypes->patchEntity($sectionType, $this->request->getData());
            if ($this->SectionTypes->save($sectionType)) {
                $this->Flash->success(__('The section type has been saved.'));

                return $this->redirect(['controller' => 'SectionTypes', 'action' => 'view', $sectionType->id]);
            }
            $this->Flash->error(__('The section type could not be saved. Please, try again.'));
        }
        $this->set(compact('sectionType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Section Type id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sectionType = $this->SectionTypes->get($id);
        if ($this->SectionTypes->delete($sectionType)) {
            $this->Flash->success(__('The section type has been deleted.'));
        } else {
            $this->Flash->error(__('The section type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
