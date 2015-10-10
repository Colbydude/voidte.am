<?php

namespace App\Library\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \App\Library\Repositories\LinkRepositoryInterface::class,
            \App\Library\Repositories\DbLinkRepository::class
        );
    }
}
