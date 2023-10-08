<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * UpdateCounterCaches shell command.
 */
class UpdateCounterCachesCommand extends Command
{
    /**
     * Current models with counterCache behaviours attached. Edit prior to use.
     *
     * @var array $_models
     */
    private array $models = [
        'UserContacts',
        'Roles',
    ];

    /**
     * main() method. Update the counterCache on a provided model or all models
     *
     * @param \Cake\Console\Arguments $args Console Arguments
     * @param \Cake\Console\ConsoleIo $consoleIo Console IO output
     * @return void Success or error code.
     */
    public function execute(Arguments $args, ConsoleIo $consoleIo): void
    {
        $consoleIo->out($this->getOptionParser()->help());

        if ($args->hasArgument('model')) {
            $model = $args->getArgument('model');
            $this->loadModel($model);
            $consoleIo->info(__('Updating CounterCache on {0}', $model));

            $assoc = !$args->hasArgument('association') ?? null;
            $records = $this->{$model}->updateCounterCache($assoc);
            $consoleIo->out("{$records} records updated");
        } else {
            foreach ($this->models as $model) {
                $this->loadModel($model);
                $consoleIo->out(__('Updating CounterCache on {0}', $model));
                $records = $this->{$model}->updateCounterCache();
                $consoleIo->out("{$records} records updated");
            }
        }
    }

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @param \Cake\Console\ConsoleOptionParser $parser ConsoleParser for chaining
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser
            ->addArgument('model', [
                'index' => 0,
                'required' => false,
                'help' => __('Provide a specific model to update'),
            ])
            ->addArgument('association', [
                'index' => 1,
                'required' => false,
                'help' => __('Provide a specific association on the model'),
            ])
            ->setDescription(__('Update all CounterCaches on all known Models.'));

        return $parser;
    }
}
