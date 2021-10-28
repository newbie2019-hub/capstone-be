<?php

namespace Database\Seeders;

use App\Models\OrgUnitRole;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $roles = OrgUnitRole::get();

        // foreach($roles as $role){
        //     for($i = 1; $i <= 12; $i++){
        //         PermissionRole::create([
        //             'org_unit_role_id' => $role->id,
        //             'permission_id' => $i
        //         ]);
        //     }
        // }

        //PRESIDENT PERMISSION
        for($i = 1; $i <= 12; $i++){
            PermissionRole::create([
                'org_unit_role_id' => 1,
                'permission_id' => $i,
            ]);
        }

        //UNIT CHAIR PERMISSION
        for($i = 1; $i <= 17; $i++){
            PermissionRole::create([
                'org_unit_role_id' => 9,
                'permission_id' => $i,
            ]);
        }

        //1,3,7,8,11
        $permission = [1,3,7,8,11,14];
        for($role = 2; $role <= 8; $role++){
            for($p = 0; $p < count($permission); $p++){
                PermissionRole::create([
                    'org_unit_role_id' => $role,
                    'permission_id' => $permission[$p],
                ]);
            }
        }

        for($p = 0; $p < count($permission); $p++){
            PermissionRole::create([
                'org_unit_role_id' => 10,
                'permission_id' => $permission[$p],
            ]);
        }

        for($p = 0; $p < count($permission); $p++){
            PermissionRole::create([
                'org_unit_role_id' => 11,
                'permission_id' => $permission[$p],
            ]);
        }
    }
}
