<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Model\Entity\ScoutGroup;
use App\Model\Entity\Section;
use App\Model\Entity\SectionType;
use Cake\Utility\Hash;

/**
 * Sections Controller
 *
 * @property \App\Model\Table\SectionsTable $Sections
 * @method \App\Model\Entity\Section[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SectionsController extends AppController
{
    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        parent::initialize();

        $config = [
            'actions' => [
                'index',
                'view',
            ],
        ];
        $this->loadComponent('Expose.Superimpose', $config);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $sections = $this->Sections
            ->find('all', [
                'fields' => [
                    Section::FIELD_UUID,
                    Section::FIELD_SECTION,
                    Section::FIELD_MEETING_START_TIME,
                    Section::FIELD_MEETING_END_TIME,
                    Section::FIELD_MEETING_DAY,
                ],
            ])
            ->contain([
                'ScoutGroups' => [
                    'fields' => [
                        ScoutGroup::FIELD_UUID,
                        ScoutGroup::FIELD_SCOUT_GROUP,
                        ScoutGroup::FIELD_GROUP_ALIAS,
                        ScoutGroup::FIELD_GROUP_DOMAIN,
                    ],
                ],
                'SectionTypes' => [
                    'fields' => [
                        SectionType::FIELD_SECTION_TYPE,
                    ],
                ],
            ]);

        $sections = $sections->toArray();
        $sections = Hash::map($sections, '{n}', function (Section $array) {
            return $array->toArray();
        });
        $sections = Hash::remove($sections, '{n}.uuid');
        $sections = Hash::remove($sections, '{n}._id');
        $sections = Hash::remove($sections, '{n}.scout_group.uuid');
        $sections = Hash::remove($sections, '{n}.scout_group._id');
        $sections = Hash::map($sections, '{n}', function ($array) {
            $array['section_type'] = Hash::extract($array, 'section_type.section_type')[0];

            return $array;
        });

        $this->set('sections', $sections);
        $this->viewBuilder()->setOption('serialize', 'sections');
    }
}
