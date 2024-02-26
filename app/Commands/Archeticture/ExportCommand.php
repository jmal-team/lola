<?php

namespace App\Commands\Archeticture;

use App\Archeticture;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class ExportCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'arch:export';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Export a single or multiple archetictures to a json file in the current directory';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $names = $this->choice(
            'Select the commands that you want to export',
            Archeticture::query()->pluck('name')->toArray(),
            multiple: true
        );

        $archetictures = Archeticture::query()->whereIn('name', $names)->get();
        $json = collect($archetictures)->map(fn ($archeticture) => $archeticture->toArray())->toArray();

        $this->task('exporting data', function () use ($json) {
            File::put('lola-archetictures.json', json_encode($json));
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
