<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var string[] All available app command names.
     */
    protected $commands = [
        Commands\Backoffice\UserAddCommand::class,
        Commands\Backoffice\UserRoleAddCommand::class,
        Commands\Backoffice\UserPermissionAddCommand::class,
        Commands\Backoffice\RoleAddCommand::class,
        Commands\Backoffice\RolePermissionAddCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }
}
