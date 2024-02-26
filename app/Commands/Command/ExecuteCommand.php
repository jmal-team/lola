<?php

namespace App\Commands\Command;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use App\Command as AppCommand;
use App\Trait\HasError;
use App\Trait\HasSearch;

class ExecuteCommand extends Command
{
    use HasError;
    use HasSearch;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'command:exec';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Execute a custom command that you added before';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $command = $this->search(
            'the name of the command that you are searching for',
            'name',
            AppCommand::query(),
            errorMessage: 'you can\'t execute this command because you have a command with the same name in the database'
        );

        $this->task('running commands', function () use ($command) {
            foreach ($command->commands as $cmd) {
                $this->info(shell_exec($cmd));
            }
        });
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
