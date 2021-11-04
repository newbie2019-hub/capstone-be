<?php

namespace App\Providers;

use App\Models\UserAccount;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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
        
        Gate::define('access_organization', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('access_organization', $user) ? true : false;
        });

        Gate::define('assign_org_adviser', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('assign_org_adviser', $user) ? true : false;
        });

        Gate::define('approve_user', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('approve_user', $user) ? true : false;
        });

        Gate::define('retrieve_users', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('retrieve_users', $user) ? true : false;
        });
        
        Gate::define('view_users', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('view_users', $user) ? true : false;
        });

        Gate::define('update_user', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('update_user', $user) ? true : false;
        });
        
        Gate::define('delete_user', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('delete_user', $user) ? true : false;
        });

        Gate::define('approve_post', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('approve_post', $user) ? true : false;
        });
        
        Gate::define('add_user', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('add_user', $user) ? true : false;
        });

        Gate::define('retrieve_post', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('retrieve_post', $user) ? true : false;
        });
        
        Gate::define('delete_post', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('delete_post', $user) ? true : false;
        });

        Gate::define('update_post', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('update_post', $user) ? true : false;
        });
        
        Gate::define('view_post', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('view_post', $user) ? true : false;
        });
        
        Gate::define('org_view_post', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('org_view_post', $user) ? true : false;
        });

        Gate::define('view_all_posts', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('view_all_posts', $user) ? true : false;
        });

        Gate::define('org_approve_member', function (UserAccount $user, $id) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('org_approve_member', $user) ? true : false;
        });

        Gate::define('view_org_member_post', function (UserAccount $user, $id) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('view_org_member_post', $user) ? true : false;
        });

        Gate::define('osa_permissions', function (UserAccount $user, $id) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('osa_permissions', $user) ? true : false;
        });

        Gate::define('osa_announcements', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('osa_announcements', $user) ? true : false;
        });

        Gate::define('osa_faqs_management', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('osa_faqs_management', $user) ? true : false;
        });

        Gate::define('osa_tel_directory', function (UserAccount $user) {
            $user = $user->userinfo->role->permission->pluck('permission')->toArray();
            return in_array('osa_tel_directory', $user) ? true : false;
        });
    }
}
