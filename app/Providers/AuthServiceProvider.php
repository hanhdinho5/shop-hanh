<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        $permissions = Permission::all();
        foreach ($permissions as $permission){
            Gate::define($permission->slug, function(User $user) use ($permission){
                return $user->hasPermission($permission->slug);
            });
        }
        
        Paginator::useBootstrap();
        Schema::defaultStringLength(200);

    }
}
