<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Lesson\Repositories\LessonRepositoryInterface;
use App\Services\Lesson\Repositories\EloquentLessonRepository;

class RepositoryInterfaceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(LessonRepositoryInterface::class, function() {
            return new EloquentLessonRepository();
        });
    }
}