<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Utility\CapBuilder;
use Cake\ORM\Entity;

/**
 * Capability Entity
 *
 * @property int $id
 * @property string $capability_code
 * @property string $capability
 * @property int $min_level
 *
 * @property \App\Model\Entity\RoleType[] $role_types
 *
 * @property string $crud_function
 * @property string $applicable_model
 * @property bool $is_field_capability
 * @property string $applicable_field
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Capability extends Entity
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
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $_accessible = [
        'capability_code' => true,
        'capability' => true,
        'role_types' => true,
        'min_level' => true,
    ];

    /**
     * @return bool
     */
    private function specialCode(): bool
    {
        return (bool)CapBuilder::isSpecialCode($this->capability_code);
    }

    /**
     * @return bool
     */
    protected function _getIsFieldCapability(): bool
    {
        return (bool)CapBuilder::isFieldType($this->capability_code);
    }

    /**
     * Specifies the method for building up a user's full name.
     *
     * @return string
     */
    protected function _getCrudFunction(): string
    {
        if (is_null($this->capability_code)) {
            return 'EMPTY';
        }

        if ($this->specialCode()) {
            return 'SPECIAL';
        }

        return CapBuilder::breakCode($this->capability_code)['crud'];
    }

    /**
     * Specifies the method for building up a user's full name.
     *
     * @return string
     */
    protected function _getApplicableModel(): string
    {
        if (is_null($this->capability_code)) {
            return 'EMPTY';
        }

        if ($this->specialCode()) {
            return 'SPECIAL';
        }

        return CapBuilder::breakCode($this->capability_code)['model'];
    }

    /**
     * Specifies the method for building up a user's full name.
     *
     * @return string
     */
    protected function _getApplicableField(): string
    {
        if ($this->is_field_capability) {
            return CapBuilder::breakCode($this->capability_code)['field'];
        }

        return '';
    }

    /**
     * Exposed Virtual Properties
     *
     * @var array
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $_virtual = ['crud_function', 'applicable_model', 'applicable_field', 'is_field_capability'];

    public const FIELD_ID = 'id';
    public const FIELD_CAPABILITY_CODE = 'capability_code';
    public const FIELD_CAPABILITY = 'capability';
    public const FIELD_MIN_LEVEL = 'min_level';
    public const FIELD_ROLE_TYPES = 'role_types';
    public const FIELD_CRUD_FUNCTION = 'crud_function';
    public const FIELD_APPLICABLE_MODEL = 'applicable_model';
    public const FIELD_IS_FIELD_CAPABILITY = 'is_field_capability';
    public const FIELD_APPLICABLE_FIELD = 'applicable_field';
}
