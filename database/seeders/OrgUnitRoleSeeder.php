<?php

namespace Database\Seeders;

use App\Models\OrgUnitRole;
use Illuminate\Database\Seeder;

class OrgUnitRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleOrg = [
            ['role' => 'President'],
            ['role' => 'Vice President'],
            ['role' => 'Secretary'],
            ['role' => 'Treasurer'],
            ['role' => 'Auditor I'],
            ['role' => 'Auditor II'],
            ['role' => 'PIO'],
            ['role' => 'Representative'],
        ];

        foreach($roleOrg as $orgRole){
            OrgUnitRole::create($orgRole + [
               'type' => 'Organization'
            ]);
        }

        $roleUnit = [
            ['role' => 'Unit Chair'],
            ['role' => 'Secretary'],
            ['role' => 'Faculty Member'],
        ];

        foreach($roleUnit as $unitrole){
            OrgUnitRole::create($unitrole + [
               'type' => 'Department'
            ]);
        }
    }
}
