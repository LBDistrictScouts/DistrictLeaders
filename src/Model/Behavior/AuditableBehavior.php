<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Exception\MissingBehaviorException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * Auditable behavior
 *
 * @property \App\Model\Table\AuditsTable $Audits
 */
class AuditableBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'tracked_fields' => [],
    ];

    /**
     * after Save LifeCycle Callback
     *
     * @param \Cake\Event\Event $event The Event to be Processed
     * @param \Cake\ORM\Entity $entity The Entity on which the Save is being Called.
     * @param array $options Options Values
     * @return bool
     */
    public function afterSave(\Cake\Event\EventInterface $event, $entity, $options)
    {
        if ($this->getTable()->hasAssociation('Audits')) {
            $this->Audits = TableRegistry::getTableLocator()->get('Audits');
        } else {
            throw new MissingBehaviorException('Audits Association is not present.');
        }

        $dirtyValues = $entity->getDirty();

        $trackedFields = $this->_config['tracked_fields'];
        $auditCount = 0;

        foreach ($dirtyValues as $dirty_value) {
            if (in_array($dirty_value, $trackedFields)) {
                $current = $entity->get($dirty_value);
                $original = $entity->getOriginal($dirty_value);

                if ($entity->isNew()) {
                    $original = null;
                }

                if ($current <> $original) {
                    $auditData = [
                        'audit_record_id' => $entity->get('id'),
                        'audit_field' => $dirty_value,
                        'audit_table' => $this->getTable()->getRegistryAlias(),
                        'original_value' => $original,
                        'modified_value' => $current,
                    ];

                    $audit = $this->Audits->newEntity($auditData);
                    $this->Audits->save($audit);
                    $auditCount += 1;
                }
            }
        }

        if ($auditCount > 0) {
            $this->getTable()->getEventManager()->dispatch(new Event(
                'Model.' . Inflector::singularize($this->getTable()->getRegistryAlias()) . '.newAudits',
                $this,
                [
                    'entity' => $entity,
                    'count' => $auditCount,
                ]
            ));
        }

        return true;
    }
}
