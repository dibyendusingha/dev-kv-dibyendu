<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        //\App\Console\Commands\testCommand::class,
        \App\Console\Commands\englishCommand::class,
        \App\Console\Commands\hindiCommand::class,
        \App\Console\Commands\bengaliCommand::class,
        \App\Console\Commands\PostBoost::class,
        \App\Console\Commands\StatusUpdate::class,
        \App\Console\Commands\SubscribedNotification::class,
        \App\Console\Commands\Notification_today_login::class,
        \App\Console\Commands\Notification_state_user::class,
        \App\Console\Commands\Notification_sent::class,
        \App\Console\Commands\subscribed_boosts_expiry::class,
        \App\Console\Commands\n_product_boost_cta::class,
        \App\Console\Commands\Prefered_user::class,
        \App\Console\Commands\sms_sent_n_product_boost_user::class,
        \App\Console\Commands\Notification_interest::class,
        \App\Console\Commands\user_post_not_ads_give::class,
        \App\Console\Commands\OfflineMembershipBufferDay::class,
        \App\Console\Commands\OfflineMembershipExpire::class,
        \App\Console\Commands\OfflineMembershipDueClear::class,

        # CROPS
        \App\Console\Commands\CropsExpiry::class,
        \App\Console\Commands\CropsNotificationDayWish::class,
    ];

    //  protected $commands = [
    //     Commands\testCommand::class,
    //  ];

    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('test:cron')->dailyAt('19:24');
        $schedule->command('english:cron')->daily();
        $schedule->command('hindi:cron')->daily();
        $schedule->command('bengali:cron')->daily();
        $schedule->command('post:boost')->daily();
        $schedule->command('subscribe:update')->everySecond();
        $schedule->command('subscribed:notification')->everySecond();
        $schedule->command('app:notification_today_login')->everySecond();
        $schedule->command('app:notification_state_user')->everySecond();
        $schedule->command('app:notification_sent')->everySecond();
        $schedule->command('subscribed_boosts:expiry')->everySecond();
        $schedule->command('n_product_boost_cta:data_save')->daily();
        $schedule->command('Prefered:user_save')->daily();
        $schedule->command('Sms_Sent:Prefer_User')->daily();
        $schedule->command('app:n_seller_not-post')->everySecond();
        $schedule->command('app:n_seller-post_not_-ads')->everySecond();
        $schedule->command('user_post:not_ads_give')->daily();
        $schedule->command('app:notification_interest')->everySecond();
        $schedule->command('offline-membership:bufferDays')->daily();
        $schedule->command('offline-membership:expire')->daily();
        $schedule->command('offline-membership:due-clear')->daily();

        # CROPS 
        $schedule->command('crops:expiry')->everyFiveSeconds();
        $schedule->command('crops:notification-day-wish')->everyFiveSeconds();

        // $schedule->command('crops:expiry')->daily();
        // $schedule->command('crops:notification-day-wish')->daily();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
    */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
