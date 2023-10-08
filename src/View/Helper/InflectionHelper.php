<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\Utility\Inflector;
use Cake\View\Helper;

/**
 * Inflection helper
 */
class InflectionHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $_defaultConfig = [];

    /**
     *  Humanise
     *
     * @param ?string $text The Text to be humanised
     * @return ?string
     */
    public function space(?string $text): ?string
    {
        if (is_null($text)) {
            return null;
        }

        return Inflector::humanize(Inflector::underscore($text));
    }

    /**
     *  Humanise
     *
     * @param ?string $text The Text to be humanised
     * @return ?string
     */
    public function singleSpace(?string $text): ?string
    {
        if (is_null($text)) {
            return null;
        }

        return Inflector::singularize($this->space($text));
    }
}
