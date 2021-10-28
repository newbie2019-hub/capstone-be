<?php

namespace Database\Seeders;

use App\Models\UndergraduatePrograms;
use Illuminate\Database\Seeder;

class UnderGraduateProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = [
            ['program' => 'AB COM'],
            ['program' => 'AB POL SCI'],
            ['program' => 'AB English'],
            ['program' => 'BEED'],
            ['program' => 'BSED'],
            ['program' => 'BSIT'],
            ['program' => 'BSTM'],
            ['program' => 'BSHM'],
            ['program' => 'BSHAE'],
            ['program' => 'BSHRM'],
            ['program' => 'BSSW'],
            ['program' => 'BSTHRM'],
            ['program' => 'BSBIO'],
            ['program' => 'BSMATH'],
            ['program' => 'BLIS'],
        ];

        foreach ($programs as $prog){
            UndergraduatePrograms::create($prog);
        }
    }
}
