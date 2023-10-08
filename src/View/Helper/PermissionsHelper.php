<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Model\Entity\User;
use Cake\Datasource\EntityInterface;
use Cake\View\Helper;

/**
 * Class Permissions Helper
 *
 * @package App\View\Helper
 * @property \Authentication\View\Helper\IdentityHelper $Identity
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class PermissionsHelper extends Helper
{
    /**
     * @var array|array<string> List of Helpers to be Loaded.
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    public $helpers = ['Identity', 'Html'];

    /**
     * @param string $buttonLabel The Label on the Button
     * @param \Cake\Datasource\EntityInterface $resource The Entity Resource
     * @param string|null $action The link Action required
     * @param string|null $controller The Link Controller
     * @param array<string>|null $class The Button Class
     * @return string
     */
    public function dropDownButton(
        string $buttonLabel,
        EntityInterface $resource,
        ?string $action = 'view',
        ?string $controller = null,
        ?array $class = []
    ): string {
        return $this->button(
            $buttonLabel,
            $resource,
            $action,
            $controller,
            [
                'role' => ['presentation'],
                'class' => $this->withOptionDefault($class, 'dropdown-item'),
            ]
        );
    }

    /**
     * @var array|array<string> Default Config Array
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $_config = [
        'class',
        'role',
    ];

    /**
     * @param string $buttonLabel The Label on the Button
     * @param \Cake\Datasource\EntityInterface $resource The Entity Resource
     * @param string|null $action The link Action required
     * @param string|null $controller The Link Controller
     * @param array|null $buttonOptions The Button Options
     * @return string
     */
    public function button(
        string $buttonLabel,
        EntityInterface $resource,
        ?string $action = 'view',
        ?string $controller = null,
        ?array $buttonOptions = []
    ): string {
        if (is_null($controller)) {
            $controller = $resource->getSource();
        }

        if (
            $this->Identity->buildAndCheckCapability($action, $controller)
            || $this->hasEditOwn($resource)
        ) {
            if (is_null($controller)) {
                $controller = $resource->getSource();
            }

            return $this->Html->link(
                $buttonLabel,
                ['controller' => $controller, 'action' => $action, $resource->id],
                $this->getButtonOptions($buttonOptions)
            );
        }

        return '';
    }

    protected array $validButtonOptions = [
        'class',
        'role',
    ];

    /**
     * @param array $buttonOptions The Options processor for the Button Class
     * @return array
     */
    protected function getButtonOptions(array $buttonOptions): array
    {
        $finalOptions = [];

        foreach ($buttonOptions as $optionKey => $option) {
            if (!empty($option) && in_array($optionKey, $this->validButtonOptions)) {
                if (is_array($option)) {
                    $optionString = '';
                    foreach ($option as $modifier) {
                        if (empty($optionString)) {
                            $optionString .= $modifier;
                        } else {
                            $optionString .= ' ' . $modifier;
                        }
                    }
                } else {
                    $optionString = $option;
                }

                $finalOptions[$optionKey] = $optionString;
            }
        }

        return $finalOptions;
    }

    /**
     * @param array $class Exposed Class
     * @param string $default Default Button Type String
     * @return array
     */
    protected function withOptionDefault(array $class, string $default): array
    {
        return array_merge([$default], $class);
    }

    /**
     * @param \Cake\Datasource\EntityInterface $resource The Resource for evaluating
     * @return bool
     */
    protected function hasEditOwn(EntityInterface $resource): bool
    {
        if ($resource instanceof User && $resource->id == $this->Identity->getId()) {
            return $this->Identity->checkCapability('OWN_USER');
        }

        return false;
    }
}
