<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\ScoutGroup;

/**
 * ScoutGroups Controller
 *
 * @property \App\Model\Table\ScoutGroupsTable $ScoutGroups
 * @method \App\Model\Entity\ScoutGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ScoutGroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $scoutGroups = $this->paginate($this->ScoutGroups);

        $this->set(compact('scoutGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Scout Group id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $scoutGroup = $this->ScoutGroups->get($id, [
            'contain' => ['Sections'],
        ]);

        $this->set('scoutGroup', $scoutGroup);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $scoutGroup = $this->ScoutGroups->newEmptyEntity();
        if ($this->request->is('post')) {
            $scoutGroup = $this->ScoutGroups->patchEntity($scoutGroup, $this->request->getData());
            if ($this->ScoutGroups->save($scoutGroup)) {
                $this->Flash->success(__('The scout group has been saved.'));

                return $this->redirect(['action' => 'view', $scoutGroup->get(ScoutGroup::FIELD_ID)]);
            }
            $this->Flash->error(__('The scout group could not be saved. Please, try again.'));
        }
        $this->set(compact('scoutGroup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Scout Group id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $scoutGroup = $this->ScoutGroups->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $scoutGroup = $this->ScoutGroups->patchEntity($scoutGroup, $this->request->getData());
            if ($this->ScoutGroups->save($scoutGroup)) {
                $this->Flash->success(__('The scout group has been saved.'));

                return $this->redirect(['action' => 'view', $scoutGroup->get(ScoutGroup::FIELD_ID)]);
            }
            $this->Flash->error(__('The scout group could not be saved. Please, try again.'));
        }
        $this->set(compact('scoutGroup'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Scout Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $scoutGroup = $this->ScoutGroups->get($id);
        if ($this->ScoutGroups->delete($scoutGroup)) {
            $this->Flash->success(__('The scout group has been deleted.'));
        } else {
            $this->Flash->error(__('The scout group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
