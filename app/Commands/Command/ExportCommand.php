<?php

namespace App\Commands\Command;

use App\Command as AppCommand;
use App\Trait\HasSearch;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class ExportCommand extends Command
{
    use HasSearch;
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'command:export';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Export a single or multiple commands to a json file in the current directory';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $names = $this->search(
            'Select the commands that you want to export',
            'name',
            AppCommand::query(),
            errorMessage: 'you can\'t export this command because you don\'t have any command with the same slug in the database'
        );

        $commands = AppCommand::query()->whereIn('name', $names)->get();

        $json = collect($commands)->map(fn ($command) => $command->toArray())->toArray();

        $this->task('exporting data', function () use ($json) {
            File::put('lola-commands.json', json_encode($json));
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
