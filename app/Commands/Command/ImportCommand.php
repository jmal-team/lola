<?php

namespace App\Commands\Command;

use App\Command as AppCommand;
use App\Trait\HasArguments;
use App\Trait\HasError;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class ImportCommand extends Command
{
    use HasArguments;
    use HasError;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'cmd:import {path? : the path of json file}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Import a json file to database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = $this->validateAndAsk('path', 'The path of json file (default is lola-commands.json)', default: 'lola-commands.json');

        if (!File::exists($path)) {
            $this->errorAndDie('the path that you specified is invalid');
        }

        if (File::extension($path) != 'json') {
            $this->errorAndDie('the file that you specified is invalid you should import from json file only');
        }

        $this->task('importing data', function () use ($path) {
            $data = File::json($path);
            foreach ($data as $item) {
                AppCommand::create([
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                    'commands' => $item['commands'],
                ]);
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