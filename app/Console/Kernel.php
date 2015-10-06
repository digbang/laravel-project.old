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
        Commands\Backoffice\AddUserCommand::class,
        Commands\Backoffice\AddRoleCommand::class,
        Commands\Backoffice\UserAddPermissionCommand::class,
        Commands\Backoffice\UserAddRoleCommand::class,
        Commands\Backoffice\RoleAddPermissionCommand::class,
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
