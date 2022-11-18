<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use app\Repositories\BookRepository;
use App\Interfaces\BookInterface;
class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Interfaces\BookInterface',
            'app\Repositories\BookRepository'
        );
    }
}