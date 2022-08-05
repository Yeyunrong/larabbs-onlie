<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //自定义自动授权注册的规则
        Gate::guessPolicyNamesUsing(function($modelClass) {
            //动态返回模型对应的策略名称，如： //‘App\Model\User’ => 'App\Pilicies\UserPolicy'
            return 'App\Policies\\'.class_basename($modelClass).'Policy';
        });
    }
}
