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

        //PRESIDENT PERMISSION
        for($i = 1; $i <= 12; $i++){
            PermissionRole::create([
                'org_unit_role_id' => 1,
                'permission_id' => $i,
            ]);
        }

        // ORGANIZATION USER x DEP PERMISSIONS
        //----------------------------//
        PermissionRole::create([
            'org_unit_role_id' => 1,
            'permission_id' => 18,
        ]);

        PermissionRole::create([
            'org_unit_role_id' => 1,
            'permission_id' => 19,
        ]);

        PermissionRole::create([
            'org_unit_role_id' => 1,
            'permission_id' => 20,
        ]);

        //----------------------------//

        //UNIT CHAIR PERMISSION
        for($i = 1; $i <= 20; $i++){
            PermissionRole::create([
                'org_unit_role_id' => 9,
                'permission_id' => $i,
            ]);
        }

        //1,3,7,8,11,14,18,19,20
        $permission = [1,3,7,8,11,14,18,19,20];
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

        $osa_permission = [21, 22, 23, 24, 25, 26];
        for($osa = 0; $osa < count($osa_permission); $osa++){
            PermissionRole::create([
                'org_unit_role_id' => 12,
                'permission_id' => $osa_permission[$osa]
            ]);
        }
    }
}
