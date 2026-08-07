<?php

namespace App\Providers;

use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use App\Repositories\Eloquent\EloquentPlayerNoteRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            PlayerNoteRepositoryInterface::class,
            EloquentPlayerNoteRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
