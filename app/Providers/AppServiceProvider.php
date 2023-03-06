<?php

namespace App\Providers;

use App\Helpers\Telegram;
use App\Models\Asset;
use App\Models\Clients\Client;
use App\Models\Movies\Movie;
use App\Models\Permission;
use App\Models\Role;
use App\Models\SocialProvider;
use App\Models\Tasks\Task;
use App\Models\User;
use App\Models\UserKey;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Http;
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
        $this->app->bind(Telegram::class, function () {
            return new Telegram(new Http(), config('telegram.token'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Relation::enforceMorphMap([
            'asset' => Asset::class,
            'permission' => Permission::class,
            'role' => Role::class,
            'social-provider' => SocialProvider::class,
            'user' => User::class,
            'user-key' => UserKey::class,

            'client' => Client::class,
            'movie' => Movie::class,
            'task' => Task::class,
        ]);
    }
}
