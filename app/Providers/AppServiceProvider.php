<?php

namespace App\Providers;

use App\Interfaces\ICardAuth;
use App\Interfaces\ITransferMoney;
use App\Utils\CardAuth;
use App\Utils\TransferMoney;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ICardAuth::class,CardAuth::class);
        $this->app->bind(ITransferMoney::class,TransferMoney::class);
    }
}
