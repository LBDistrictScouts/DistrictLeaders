<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;

/**
 * Markdown helper
 */
class MarkdownHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected array $_defaultConfig = [];

    /**
     * @var \League\CommonMark\CommonMarkConverter
     */
    protected CommonMarkConverter $converter;

    /**
     * {@inheritDoc}
     *
     * @param array $config Array for configuration
     * @return void
     */
    public function initialize(array $config): void
    {
        // Obtain a pre-configured Environment with all the CommonMark parsers/renderers ready-to-go
        $environment = Environment::createCommonMarkEnvironment();

        // Define your configuration:
        $config = [];

        // Now that the `Environment` is configured we can create the converter engine:
        $this->converter = new CommonMarkConverter($config, $environment);

        parent::initialize($config);
    }

    /**
     * @param string $markdownStream The Markdown Stream to be converted to html
     * @return string
     */
    public function markdownToHtml(string $markdownStream): string
    {
        return $this->converter->convertToHtml($markdownStream);
    }
}
