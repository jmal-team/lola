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
    protected $signature = 'command:delete';

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
        $command = $this->search(
            'the name of the command that you are searching for',
            'name',
            AppCommand::query(),
            errorMessage: 'you can\'t delete this command because you don\'t have any command with the same slug in the database'
        );

        $this->task('deleting command', function () use ($command) {
            $command->delete();
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
