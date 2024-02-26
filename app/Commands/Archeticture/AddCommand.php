<?php

namespace App\Commands\Archeticture;

use App\Archeticture;
use App\Helpers\FileDirectoryHelper;
use App\Trait\HasArguments;
use App\Trait\HasError;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;
use SebastianBergmann\CodeCoverage\Node\Directory;

class AddCommand extends Command
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

        $description = $this->validateAndAsk('description', 'What is the description of your archeticture?');
        $path = FileDirectoryHelper::currentDirectory() . '/' . $this->ask('What is the path of your archeticture? (default is current path)');
        if (!File::exists($path)) {
            $this->errorAndDie('the path that you specified is invalid');
        }

        $content = FileDirectoryHelper::getContent($path);

        $arheticture = Archeticture::create([
            'name' => $name,
            'description' => $description,
            'tree' => $content,
        ]);
        $this->info('added a new arheticture');
        $this->info($arheticture);
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
