<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;

/**
 * Caseable behavior
 */
class CaseableBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'case_columns' => [],
    ];

    /**
     * Stores emails as lower case.
     *
     * @param \Cake\Event\Event $event The event being processed.
     * @param \Cake\ORM\Entity $entity The Entity being processed.
     *
     * @return bool
     */
    public function beforeRules($event, $entity)
    {
        $dirty = $entity->getDirty();
        $columns = $this->_config['case_columns'];

        foreach ($columns as $column => $case) {
            switch ($case) {
                case 'l':
                    $changed = strtolower($entity->get($column));
                    break;
                case 't':
                    $changed = ucwords(strtolower($entity->get($column)));
                    break;
                case 'u':
                    $changed = strtoupper($entity->get($column));
                    break;
                default:
                    $changed = $entity->get($column);
                    break;
            }

            $entity->set($column, $changed);
        }

        $cleaned = array_keys($columns);

        foreach ($cleaned as $clean) {
            if (!in_array($clean, $dirty)) {
                $entity->setDirty($clean, false);
            }
        }

        return true;
    }
}
