<?php

namespace App\Providers;

use App\Models\Module;
use App\Models\User;
use App\Models\Group;
use App\Models\Post;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Policies\GroupPolicy;
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
        Post::class => PostPolicy::class,
        User::class => UserPolicy::class,
        Group::class => GroupPolicy::class,
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
                        return isRole($roleArr, $module->name, 'view');
                    }
                    return false;
                });

                Gate::define($module->name.'.add', function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;
                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        return isRole($roleArr, $module->name, 'add');
                    }
                    return false;
                });

                Gate::define($module->name.'.edit', function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;
                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        return isRole($roleArr, $module->name, 'edit');
                    }
                    return false;
                });

                Gate::define($module->name.'.delete', function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;
                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        return isRole($roleArr, $module->name, 'delete');
                    }
                    return false;
                });

                Gate::define($module->name.'.permission', function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;
                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        return isRole($roleArr, $module->name, 'permission');
                    }
                    return false;
                });
            }
        }
    }
}
