<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\ORM\Behavior;

/**
 * Caseable behavior
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
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
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeRules($event, $entity)
    {
        $dirty = $entity->getDirty();
        $columns = $this->_config['case_columns'];

        foreach ($columns as $column => $case) {
            $value = $entity->get($column);

            if (!is_null($value)) {
                switch ($case) {
                    case 'l':
                        $changed = strtolower($value);
                        break;
                    case 't':
                        $changed = ucwords(strtolower($value));
                        break;
                    case 'u':
                        $changed = strtoupper($value);
                        break;
                    default:
                        $changed = $value;
                        break;
                }
                $entity->set($column, $changed);
            }
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
