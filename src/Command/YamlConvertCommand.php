<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Symfony\Component\Yaml\Dumper;

/**
 * Class PasswordCommand
 *
 * @package App\Command
 */
class YamlConvertCommand extends Command
{
    /**
     * Initialise method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser Parser Input
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('Install Configuration Options.');

        $parser->addArgument('file', [
            'required' => true,
            'help' => 'The Config File to be Converted.',
        ]);

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args Arguments for the Console
     * @param \Cake\Console\ConsoleIo $consoleIo The IO
     * @return int|null|void
     * @throws \Exception
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $consoleIo): int|null|null
    {
        $fileName = $args->getArgument('file');
        if (!preg_match('/[.]/', $fileName) || explode('.', $fileName)[1] != 'php') {
            $fileName .= '.php';
        }

        $outFile = str_replace('.php', '.yml', $fileName);

        $config = include CONFIG . $fileName;

        $dumper = new Dumper();
        $yaml = $dumper->dump($config, 5);
        file_put_contents(CONFIG . $outFile, $yaml);
    }
}
