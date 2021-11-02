<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['permission' => 'retrieve_users'], //1
            ['permission' => 'approve_user'], //2
            ['permission' => 'view_users'], //3
            ['permission' => 'update_user'], //4
            ['permission' => 'delete_user'], //5
            ['permission' => 'approve_post'], //6
            ['permission' => 'add_user'], //7
            ['permission' => 'retrieve_post'], //8
            ['permission' => 'delete_post'], //9
            ['permission' => 'update_post'], //10
            ['permission' => 'view_post'], //11
            ['permission' => 'view_all_posts'], //12
            ['permission' => 'assign_org_adviser'], //13
            ['permission' => 'access_organization'], //14
            ['permission' => 'org_view_post'], //15
            ['permission' => 'org_approve_member'], //16
            ['permission' => 'view_org_member_post'], //17
            ['permission' => 'orgunit_dashboard'], //18
            ['permission' => 'orgunit_posts'], //19
            ['permission' => 'orgunit_members'], //20
            ['permission' => 'osa_post_management'], //21
            ['permission' => 'osa_tel_directory'], //22
            ['permission' => 'osa_faqs_management'], //23
            ['permission' => 'osa_scholarship'], //24
            ['permission' => 'osa_announcements'], //25
            ['permission' => 'osa_permissions'], //26
        ];

        foreach($data as $permission){
            Permission::create($permission);
        }
    }
}
