<?php

namespace App\Providers;

use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Сопоставления политик для приложения.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Регистрация всех сервисов аутентификации / авторизации.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(Carbon::now()->addDays(15));
      
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
    }
}
