<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Organization;
use App\Models\OrgUnit;
use Illuminate\Database\Seeder;

class OrgUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = [
            ['name' => 'BSIT and Computer Education Unit'],
            ['name' => 'MAPE/PEHM/Humanities Unit'],
            ['name' => 'Mathematics Unit'],
            ['name' => 'Science Unit'],
            ['name' => 'NSTP Unit'],
            ['name' => 'Social Work Unit'],
            ['name' => 'Filipino Unit'],
            ['name' => 'Social Science Unit'],
            ['name' => 'ABCom Unit'],
            ['name' => 'Library and Information Science Unit'],
        ];

        foreach($department as $dep){
            Department::create($dep);
        }

        $organization = [
            [
                'name' => 'Developmental Integrated Group of Information Technology Students', 
                'abbreviation' => 'DIGITS',
                'department_id' => 1
            ],
            [
                'name' => 'Association of Political Science Students', 
                'abbreviation' => 'APSS',
            ],
            ['name' => 'Association of Values Educators', 'abbreviation' => 'AVED'],
            ['name' => 'Technology and Livelihood Educators Guild', 'abbreviation' => 'TLE Guild'],
            ['name' => 'BACommUNITY'],
            [
                'name' => 'BPED Movers',
                'department_id' => 2
            ],
            ['name' => 'Book Enthusiasts'],
            ['name' => 'Entrepreneurs Club'],
            ['name' => 'English Circle'],
            ['name' => 'Tourism Circle', 'abbreviation' => 'TC'],
            [
                'name' => 'Junior Social Workers\' Association of Philippines - LNU Chapter', 
                'abbreviation' => 'JSWAP',
                'department_id' => 6,
            ],
            ['name' => 'Interact Society'],
            ['name' => 'Circle of Future Educators', 'abbreviation' => 'CofEd'],
            [
                'name' => 'Math Student\'s Society', 
                'abbreviation' => 'MSS',
                'department_id' => 3
            ],
            [
                'name' => 'Science Questers Unlimited', 
                'abbreviation' => 'SQU',
                'department_id' => 4
            ],
            ['name' => 'Early Childhood Educators Organization', 'abbreviation' => 'ECEO'],
        ];

        foreach($organization as $org){
            Organization::create($org);
        }
    }
}
