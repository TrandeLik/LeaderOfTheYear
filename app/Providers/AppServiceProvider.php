<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
        $isLeaderBoardWorking = 'on';//Setting::where('name', 'Рейтинговая таблица (для учеников)')->first()->value;
        view()->share(compact('isLeaderBoardWorking'));
    }
}
