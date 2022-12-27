<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Capability;
use App\Model\Entity\RoleTemplate;
use App\Model\Table\Traits\BaseInstallerTrait;
use Cake\Database\Schema\TableSchemaInterface;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RoleTemplates Model
 *
 * @property RoleTypesTable&HasMany $RoleTypes
 * @method RoleTemplate get($primaryKey, $options = [])
 * @method RoleTemplate newEntity(array $data, array $options = [])
 * @method RoleTemplate[] newEntities(array $data, array $options = [])
 * @method RoleTemplate|false save(EntityInterface $entity, $options = [])
 * @method RoleTemplate saveOrFail(EntityInterface $entity, $options = [])
 * @method RoleTemplate patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method RoleTemplate[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method RoleTemplate findOrCreate($search, ?callable $callback = null, $options = [])
 * @method RoleTemplate[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method RoleTemplate newEmptyEntity()
 * @method RoleTemplate[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method RoleTemplate[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method RoleTemplate[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RoleTemplatesTable extends Table
{
    use BaseInstallerTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('role_templates');
        $this->setDisplayField(RoleTemplate::FIELD_ROLE_TEMPLATE);
        $this->setPrimaryKey(RoleTemplate::FIELD_ID);

        $this->hasMany('RoleTypes', [
            'foreignKey' => 'role_template_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer(RoleTemplate::FIELD_ID)
            ->allowEmptyString(RoleTemplate::FIELD_ID, null, 'create');

        $validator
            ->scalar(RoleTemplate::FIELD_ROLE_TEMPLATE)
            ->maxLength(RoleTemplate::FIELD_ROLE_TEMPLATE, 63)
            ->requirePresence(RoleTemplate::FIELD_ROLE_TEMPLATE, 'create')
            ->notEmptyString(RoleTemplate::FIELD_ROLE_TEMPLATE);

        $validator
            ->requirePresence(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, 'create')
            ->isArray(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES)
            ->allowEmptyArray(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES);

        $validator
            ->integer(RoleTemplate::FIELD_INDICATIVE_LEVEL)
            ->requirePresence(RoleTemplate::FIELD_INDICATIVE_LEVEL, 'create')
            ->notEmptyString(RoleTemplate::FIELD_INDICATIVE_LEVEL);

        return $validator;
    }

    /**
     * @param TableSchemaInterface $schema The Schema to be modified
     * @return TableSchemaInterface
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _initializeSchema(TableSchemaInterface $schema): TableSchemaInterface
    {
        $schema->setColumnType(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, 'json');

        return $schema;
    }

    /**
     * before Save LifeCycle Callback
     *
     * @param EventInterface $event The Event to be Processed
     * @param RoleTemplate $entity The Entity on which the Save is being Called.
     * @param array $options Options Values
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeSave(EventInterface $event, $entity, $options)
    {
        if (
            $entity->isNew()
            || $entity->getOriginal(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES) != $entity->template_capabilities
            || $entity->isDirty(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES)
        ) {
            $this->getEventManager()->dispatch(new Event(
                'Model.RoleTemplates.templateChange',
                $this,
                ['role_template' => $entity]
            ));
        }

        return true;
    }

    /**
     * Function to install base entities from Config
     *
     * @return int
     */
    public function installBaseRoleTemplates()
    {
        $count = 0;
        $roleTemplates = $this->getBaseValues($this);

        foreach ($roleTemplates as $roleTemplate) {
            if ($this->installBaseRoleTemplate($roleTemplate)) {
                $count += 1;
            }
        }

        return $count;
    }

    /**
     * function to install a template from Configuration
     *
     * @param array $roleTemplate Role Template Array for Config
     * @return bool
     */
    public function installBaseRoleTemplate($roleTemplate)
    {
        // Quit loop if keys not present
        if (!key_exists('template_name', $roleTemplate) || !key_exists('core_level', $roleTemplate)) {
            return false;
        }

        // Generate core level templates
        if (!key_exists('capabilities', $roleTemplate)) {
            $roleTemplateEntity = $this->makeCoreTemplate($roleTemplate['template_name'], $roleTemplate['core_level']);
        }

        // Generate specific templates
        if (key_exists('capabilities', $roleTemplate)) {
            $roleTemplateEntity = $this->makeOrPatch([
                RoleTemplate::FIELD_ROLE_TEMPLATE => $roleTemplate['template_name'],
                RoleTemplate::FIELD_INDICATIVE_LEVEL => $roleTemplate['core_level'],
                RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => $roleTemplate['capabilities'],
            ]);
            $roleTemplateEntity = $this->save($roleTemplateEntity);
        }

        // Complete Count
        if (isset($roleTemplateEntity) && $roleTemplateEntity instanceof RoleTemplate) {
            return true;
        }

        return false;
    }

    /**
     * @param string $name The Role Template Name
     * @param int $level The Permission Level
     * @return RoleTemplate|false
     */
    public function makeCoreTemplate(string $name, int $level)
    {
        $query = $this->RoleTypes->Capabilities->find('level', ['level' => $level]);
        $capabilities = [];

        foreach ($query as $capability) {
            array_push($capabilities, $capability->get(Capability::FIELD_CAPABILITY_CODE));
        }

        $roleTemplate = $this->makeOrPatch([
            RoleTemplate::FIELD_INDICATIVE_LEVEL => $level,
            RoleTemplate::FIELD_ROLE_TEMPLATE => $name,
            RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => $capabilities,
        ]);

        return $this->save($roleTemplate);
    }

    /**
     * @param array $objectArray The array to be saved
     * @return RoleTemplate
     */
    protected function makeOrPatch(array $objectArray): RoleTemplate
    {
        if ($this->exists([RoleTemplate::FIELD_ROLE_TEMPLATE => $objectArray[RoleTemplate::FIELD_ROLE_TEMPLATE]])) {
            $roleTemplate = $this->find()
                ->where([RoleTemplate::FIELD_ROLE_TEMPLATE => $objectArray[RoleTemplate::FIELD_ROLE_TEMPLATE]])
                ->first();
        } else {
            $roleTemplate = $this->newEmptyEntity();
        }

        return $this->patchEntity($roleTemplate, $objectArray);
    }
}
