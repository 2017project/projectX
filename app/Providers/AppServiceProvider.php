<?php

namespace App\Providers;

use App\Common\Business\Repositories\MailRepository;
use App\Common\Business\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $repositories = [
        'IUserRepository' => UserRepository::class,
        'IMailRepository' => MailRepository::class,

    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        foreach ($this->repositories as $key => $repository) {
            app()->bind($key, function () use ($repository) {
                return new $repository();
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
