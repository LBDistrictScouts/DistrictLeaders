<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NotificationType Entity
 *
 * @property int $id
 * @property string|null $notification_type
 * @property string|null $notification_description
 * @property string|null $icon
 * @property string $type_code
 * @property string $content_template
 * @property Notification[] $notifications
 * @property string $type
 * @property string $sub_type
 * @property bool $repetitive
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class NotificationType extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'notification_type' => true,
        'notification_description' => true,
        'icon' => true,
        'type_code' => true,
        'content_template' => true,
        'notifications' => true,
    ];

    /**
     * @return array
     */
    private function typeSplitter()
    {
        $generationArray = explode('-', $this->type_code, 2);

        $splitArray['type'] = $generationArray[0];
        $splitArray['subType'] = $generationArray[1];

        return $splitArray;
    }

    /**
     * Notification Type
     *
     * @return string
     */
    protected function _getType(): ?string
    {
        return $this->typeSplitter()['type'];
    }

    /**
     * Notification SubType
     *
     * @return string
     */
    protected function _getSubType(): ?string
    {
        return $this->typeSplitter()['subType'];
    }

    /**
     * Notification Type
     *
     * @return bool
     */
    protected function _getRepetitive(): bool
    {
        $repetitive = ['USR-PWD', 'USR-CCH'];

        return (bool)in_array($this->type_code, $repetitive);
    }

    protected $_virtual = [
        self::FIELD_TYPE,
        self::FIELD_SUB_TYPE,
        self::FIELD_REPETITIVE,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_NOTIFICATION_TYPE = 'notification_type';
    public const FIELD_NOTIFICATION_DESCRIPTION = 'notification_description';
    public const FIELD_ICON = 'icon';
    public const FIELD_TYPE_CODE = 'type_code';
    public const FIELD_CONTENT_TEMPLATE = 'content_template';
    public const FIELD_NOTIFICATIONS = 'notifications';
    public const FIELD_TYPE = 'type';
    public const FIELD_SUB_TYPE = 'sub_type';
    public const FIELD_REPETITIVE = 'repetitive';
}
