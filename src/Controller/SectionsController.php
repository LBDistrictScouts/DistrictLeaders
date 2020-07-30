<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Filter\SectionsCollection;

/**
 * Sections Controller
 *
 * @property \App\Model\Table\SectionsTable $Sections
 * @method \App\Model\Entity\Section[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SectionsController extends AppController
{
    /**
     * @throws \Exception
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->Authorization->mapActions([
            'search' => 'index',
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->Authorization->authorize($this->Sections);

        $query = $this->Sections->find()->contain(['SectionTypes', 'ScoutGroups', 'Users']);
        $sections = $this->paginate($this->Authorization->applyScope($query));

        $this->set(compact('sections'));

        $this->whyPermitted($this->Sections);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function search()
    {
        $query = $this->Sections->find('search', [
            'search' => $this->getRequest()->getQueryParams(),
            'collection' => SectionsCollection::class,
        ])
        ->contain([
            'SectionTypes',
            'ScoutGroups',
        ]);
        $sections = $this->paginate($this->Authorization->applyScope($query));
        $this->set(compact('sections'));

        $this->whyPermitted($this->Sections);
    }

    /**
     * View method
     *
     * @param string|null $id Section id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $section = $this->Sections->get($id, [
            'contain' => ['SectionTypes', 'ScoutGroups', 'Roles'],
        ]);

        $this->set('section', $section);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $section = $this->Sections->newEmptyEntity();
        if ($this->request->is('post')) {
            $section = $this->Sections->patchEntity($section, $this->request->getData());
            if ($this->Sections->save($section)) {
                $this->Flash->success(__('The section has been saved.'));

                return $this->redirect(['action' => 'view', $section->get('id')]);
            }
            $this->Flash->error(__('The section could not be saved. Please, try again.'));
        }
        $sectionTypes = $this->Sections->SectionTypes->find('list', ['limit' => 200]);
        $scoutGroups = $this->Sections->ScoutGroups->find('list', ['limit' => 200]);
        $this->set(compact('section', 'sectionTypes', 'scoutGroups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Section id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $section = $this->Sections->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $section = $this->Sections->patchEntity($section, $this->request->getData());
            if ($this->Sections->save($section)) {
                $this->Flash->success(__('The section has been saved.'));

                return $this->redirect(['action' => 'view', $section->get('id')]);
            }
            $this->Flash->error(__('The section could not be saved. Please, try again.'));
        }
        $sectionTypes = $this->Sections->SectionTypes->find('list', ['limit' => 200]);
        $scoutGroups = $this->Sections->ScoutGroups->find('list', ['limit' => 200]);
        $this->set(compact('section', 'sectionTypes', 'scoutGroups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Section id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $section = $this->Sections->get($id);
        if ($this->Sections->delete($section)) {
            $this->Flash->success(__('The section has been deleted.'));
        } else {
            $this->Flash->error(__('The section could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
