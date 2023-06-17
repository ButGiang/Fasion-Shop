<?php

namespace App\Providers;

use App\Http\View\Composers\MenuComposer;
use App\Http\View\Composers\CartComposer;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }


    public function boot()
    {
        View::composer('main.navbar', MenuComposer::class);
        View::composer('main.cart', CartComposer::class);
    }
}
