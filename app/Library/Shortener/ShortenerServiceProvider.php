<?php

namespace App\Library\Shortener;

use Illuminate\Support\ServiceProvider;

class ShortenerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('shortener', 'App\Library\Shortener\ShortenerService');
    }
}
