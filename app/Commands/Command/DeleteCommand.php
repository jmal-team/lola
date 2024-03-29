<?php

namespace App\Commands\Command;

use App\Command as AppCommand;
use App\Trait\HasError;
use App\Trait\HasSearch;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class DeleteCommand extends Command
{
    use HasError;
    use HasSearch;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'cmd:delete';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Delete a command';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $commands = $this->search(
            'the name of the command that you are searching for',
            'name',
            AppCommand::query(),
            errorMessage: 'you can\'t delete this command because you don\'t have any command with the same slug in the database'
        );

        $this->task('deleting command', function () use ($commands) {
            $commands->each(fn ($command) => $command->delete());
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
