<?php

namespace App\Providers;

use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        $modules = Module::all();

        if ($modules->count() > 0) {
            foreach ($modules as $module) {
                Gate::define($module->name, function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;
                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        return isRole($roleArr, $module->name);
                    }
                    return false;
                });
            }
        }
    }
}
