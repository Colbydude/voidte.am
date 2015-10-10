<?php

namespace App\Library\Utilities;

use Illuminate\Support\ServiceProvider;

class UtilitiesServiceProvider extends ServiceProvider
{
    /**
     * Register in IoC container
     */
    public function register()
    {
        $this->app->bind(\App\Library\Utilities\UrlHasher::class, function () {
            $length = 7;

            return new UrlHasher($length);
        });
    }
}
