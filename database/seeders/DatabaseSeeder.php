<?php

namespace Database\Seeders;

use App\Models\OrgUnit;
use App\Models\OrgUnitRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminAccountSeeder::class,
            UnderGraduateProgramSeeder::class,
            FAQSeeder::class,
            ReviewSeeder::class,
            CoreValuesSeeder::class,
            OrgUnitSeeder::class,
            OrgUnitRoleSeeder::class,
            SchoolOfficialSeeder::class,
            UniversityInfoSeeder::class,
            TelephoneDirectorySeeder::class,
            CollegeSeeder::class,
            CourseSeeder::class,
            GoalSeeder::class,
            PermissionSeeder::class,
            ObjectiveSeeder::class,
            CourseObjectiveSeeder::class,
            UserAccountSeeder::class,
            PermissionRoleSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
