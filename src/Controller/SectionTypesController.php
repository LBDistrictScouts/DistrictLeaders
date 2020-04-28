<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SectionTypes Controller
 *
 * @property \App\Model\Table\SectionTypesTable $SectionTypes
 * @method \App\Model\Entity\SectionType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SectionTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
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
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
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
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
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
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
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
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
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
