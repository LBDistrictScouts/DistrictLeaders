<?php

declare(strict_types=1);

namespace App\Model\Behavior;

use App\Model\Table\AuditsTable;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Exception\MissingBehaviorException;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Auditable behavior
 *
 * @property AuditsTable $Audits
 */
class AuditableBehavior extends Behavior
{
    use LocatorAwareTrait;

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'tracked_fields' => [],
    ];

    public AuditsTable $Audits;

    /**
     * after Save LifeCycle Callback
     *
     * @param Event $event The Event to be Processed
     * @param Entity $entity The Entity on which the Save is being Called.
     * @param array $options Options Values
     * @return bool
     */
    public function afterSave(EventInterface $event, $entity, $options)
    {
        if ($this->table()->hasAssociation('Audits')) {
            $this->Audits = $this->getTableLocator()->get('Audits');
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
                        'audit_table' => $this->table()->getRegistryAlias(),
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
            $this->table()->getEventManager()->dispatch(new Event(
                'Model.' . $this->table()->getRegistryAlias() . '.newAudits',
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
