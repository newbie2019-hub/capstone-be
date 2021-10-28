<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\College;
use App\Models\CollegeInfo;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        College::create([
            'name' => 'College of Education',
            'abbreviation' => 'COE',
            'dean' => 'Prof. Lina G. Fabian',
        ]);

        College::create([
            'name' => 'College of Arts and Sciences',
            'abbreviation' => 'CAS',
            'dean' => 'Cleofe L. Lajara, D.A.',
        ]);

        College::create([
            'name' => 'College of Management and Entrepreneurship',
            'abbreviation' => 'CME',
            'dean' => 'Ariel B. Lunzaga, PhD',
        ]);

        College::create([
            'name' => 'Integrated Laboratory School',
            'abbreviation' => 'ILS',
        ]);
    }
}
