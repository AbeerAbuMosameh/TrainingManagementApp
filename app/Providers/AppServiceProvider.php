<?php

namespace App\Providers;

use App\Models\Advisor;
use App\Models\Notification;
use App\Models\Trainee;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
 $notifications = Notification::where('status', 'unread')->orderByDesc('created_at')
            ->get();
        $count = Notification::where('status', 'unread')->count();

        foreach ($notifications as $notification) {
            $trainee = Trainee::where('notification_id', $notification->id)->first();
            if ($trainee) {
                $notification->link = 'http://phplaravel-1011648-3574700.cloudwaysapps.com/trainees/'.$trainee->id;
            }else{
                $advisor = Advisor::where('notification_id', $notification->id)->first();
                if ($advisor) {
                    $notification->link = 'http://phplaravel-1011648-3574700.cloudwaysapps.com/trainees/'.$advisor->id;
                }
            }
        }

        // Share the data with all views
        View::share('notifications', $notifications);
        View::share('count', $count);
    }
}
