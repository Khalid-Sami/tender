<?php

namespace App\Providers;

use App\NotificationView;
use App\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class LayoutProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composer('_layout', function ($view) {
            $user_id = session('user_id');
            $data['user'] = User::where('pk_i_id',$user_id)->first();
            $data['notifications'] = NotificationView::orderBy('dt_created_date','desc')->get();
            $seen_date =  $data['user']->dt_notification_seen_date;
            DB::statement("SET @i_user_id ='$user_id'");
            if (!empty($seen_date)) {
                $data['notifications_count'] = collect(DB::select(DB::raw("SELECT COUNT(pk_i_id) as cou FROM v_notification WHERE  v_notification.dt_created_date > '$seen_date'")));
            } else {
                $data['notifications_count'] = collect(DB::select(DB::raw("SELECT COUNT(pk_i_id) as cou FROM v_notification")));
            }
            $last = NotificationView::select(DB::raw('(SELECT max(pk_i_id) as id FROM v_notification)'))->first();
            $data['last_date'] = "";
            if ( $last) {
                $last1 = NotificationView::where('pk_i_id',  $last->id)->first();
                if (!empty($last1)) {
                    $data['last_date'] = $last1->dt_created_date;
                }
            }
            $view->with($data);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
