<?php

namespace App\Commands\Archeticture;

use App\Archeticture;
use App\Helpers\FileDirectoryHelper;
use App\Trait\HasArguments;
use App\Trait\HasError;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class AddArcheticture extends Command
{
    use HasArguments;
    use HasError;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'arch:add
    {name? : the name of you command} 
    {description? : the description of the command}
    ';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Add a new archeticture';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->validateAndAsk('name', 'What is the name of your archeticture? (this should be unique)');

        if (Archeticture::query()->where('name', $name)->exists()) {
            $this->errorAndDie('you can\'t add this archeticture because you have a archeticture with the same name in the database');
        }

        $slug = Str::slug($name);
        $path = $this->ask('What is the path of your archeticture? (default is current path)');
        if (! File::exists($path)) {
            $this->errorAndDie('the path that you specified is invalid');
        }

        $content = FileDirectoryHelper::getContent($path);

        $arheticture = Archeticture::create([
            'name' => $name,
            'slug' => $slug,
            'tree' => $content,
        ]);
        $this->info('added a new arheticture');
        $this->info($arheticture);
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
