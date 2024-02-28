<?php

namespace App\Commands\Archeticture;

use App\Archeticture;
use App\Helpers\FileDirectoryHelper;
use App\Trait\HasError;
use App\Trait\HasSearch;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class PublishArcheticture extends Command
{
    use HasError;
    use HasSearch;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'arch:publish {slug? : the slug of the archeticture}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Publish an archeticture';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * @var Archeticture
         */
        $archeticture = $this->argument('slug') ? Archeticture::query()
            ->where('slug', $this->argument('slug'))
            ->firstOr(callback: fn () => $this->errorAndDie('Can\'t find any archeticture by this slug')) : $this->search(
                'the name of the archeticture that you are searching for',
                'name',
                Archeticture::query(),
                errorMessage: 'you can\'t publish this archeticture because you don\'t have any archeticture with the same name in the database'
            );

        $this->task('publishing archeticture', function () use ($archeticture) {
            foreach ($archeticture->tree as $item) {
                FileDirectoryHelper::createFile($item['name'], $item['content']);
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
