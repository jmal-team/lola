<?php

namespace App\Commands\Command;

use App\Command as AppCommand;
use App\Trait\HasArguments;
use App\Trait\HasError;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class AddCommand extends Command
{
    use HasArguments;
    use HasError;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'command:add 
    {name? : the name of you command} 
    {description? : the description of the command}
    ';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Add a custom command';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->validateAndAsk('name', 'What is the name of your command? (this should be unique)');

        if (AppCommand::query()->where('name', $name)->exists()) {
            $this->errorAndDie('you can\'t add this command because you have a command with the same name in the database');
        }
        $description = $this->validateAndAsk('description', 'What is the description of your command?');
        $commands = $this->askUntilExit('Enter the command that you want to add (if you have finished inserting your commands type `exit`)');

        $command = AppCommand::create(compact('name', 'description', 'commands'));
        $this->info('added a new command');
        $this->info($command);
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
