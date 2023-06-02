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
                $notification->link = 'http://127.0.0.1:8000/trainees/'.$trainee->id;
            }else{
                $advisor = Advisor::where('notification_id', $notification->id)->first();
                if ($advisor) {
                    $notification->link = 'http://127.0.0.1:8000/advisors/'.$advisor->id;
                }
            }
        }

        // Share the data with all views
        View::share('notifications', $notifications);
        View::share('count', $count);
    }
}
