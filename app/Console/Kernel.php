<?php

namespace App\Console;

use App\Console\Commands\ImportGroups;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ImportGroups::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule
            ->command('groups:import')
            ->twiceDaily(9, 16)
            ->thenPing(config('ministryplatform.heartbeat_import_groups'))
            ->thenPing(config('ministryplatform.cms_import_groups_url'));

        $schedule->command('groups:geocode')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
