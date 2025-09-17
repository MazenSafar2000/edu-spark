<?php

namespace App\Providers;

use App\Models\ChMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // allowed users (مع unread_count)
                $allowedUsers = $user->allowedChatUsers()
                    ->map(function ($u) use ($user) {
                        $u->unread_count = ChMessage::where('from_id', $u->id)
                            ->where('to_id', $user->id)
                            ->where('seen', 0)
                            ->count();
                        return $u;
                    });

                // كل الرسائل الغير مقروءة
                $unreadCount = ChMessage::where('to_id', $user->id)
                    ->where('seen', 0)
                    ->count();

                // مررهم لأي View
                $view->with(compact('allowedUsers', 'unreadCount'));
            }
        });
    }
}
