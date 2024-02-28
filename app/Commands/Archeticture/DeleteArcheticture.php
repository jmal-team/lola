<?php

namespace App\Commands\Archeticture;

use App\Archeticture;
use App\Trait\HasError;
use App\Trait\HasSearch;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class DeleteArcheticture extends Command
{
    use HasError;
    use HasSearch;
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'arch:delete';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Delete an Archeticture';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $archeticture = $this->search(
            'the name of the archeticture that you are searching for',
            'name',
            Archeticture::query(),
            errorMessage: 'you can\'t delete this archeticture because you don\'t have any archeticture with the same slug in the database'
        );

        $this->task('deleting archeticture', function () use ($archeticture) {
            $archeticture->delete();
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
