<?php

namespace App\Commands\Command;

use App\Command as AppCommand;
use App\Trait\HasError;
use App\Trait\HasSearch;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ExecuteCommand extends Command
{
    use HasError;
    use HasSearch;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'cmd:exec {slug? : the slug of the command}';

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
        $command = $this->argument('slug') ? AppCommand::query()
            ->where('slug', $this->argument('slug'))
            ->firstOr(callback: fn () => $this->errorAndDie('Can\'t find any archeticture by this slug')) : $this->search(
                'the name of the command that you are searching for',
                'name',
                AppCommand::query(),
                errorMessage: 'you can\'t execute this command because you have a command with the same slug in the database'
            );

        $this->task('running commands', function () use ($command) {
            foreach ($command->commands as $cmd) {
                $this->info(shell_exec($cmd));
            }
        });
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
