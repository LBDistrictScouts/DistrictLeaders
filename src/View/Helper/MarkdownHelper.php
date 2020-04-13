<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extras\CommonMarkExtrasExtension;

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
    protected $_defaultConfig = [];

    /**
     * @var \League\CommonMark\CommonMarkConverter
     */
    protected $converter;

    /**
     * @param array $config Array for configuration
     *
     * {@inheritDoc}
     * @return void
     */
    public function initialize(array $config): void
    {
        // Obtain a pre-configured Environment with all the CommonMark parsers/renderers ready-to-go
        $environment = Environment::createCommonMarkEnvironment();

        // REGISTER THIS EXTENSION HERE
        $environment->addExtension(new CommonMarkExtrasExtension());

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
    public function markdownToHtml($markdownStream)
    {
        return $this->converter->convertToHtml($markdownStream);
    }
}
