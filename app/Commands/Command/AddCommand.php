<?php

namespace App\Commands\Command;

use App\Command as AppCommand;
use App\Trait\HasArguments;
use App\Trait\HasError;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
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
    protected $signature = 'cmd:add 
    {name? : the name of you command} 
    ';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Add a new custom command';

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
        $commands = $this->askUntilExit('Enter the command that you want to add (if you have finished inserting your commands type `exit`)');
        $slug = Str::slug($name);
        $command = AppCommand::create(compact('name', 'slug', 'commands'));
        $this->info('added a new command');
        $this->info($command);
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}