<?php

namespace Database\Seeders;

use App\Models\Goal;
use Illuminate\Database\Seeder;

class GoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Goal::create([
            'goal' => 'To produce teachers who are globally competitive, empowered and imbued with high ideals, aspirations and traditions of a Filipino.',
            'college_id' => '4',
        ]);
        
        Goal::create([
            'goal' => 'To produce world class educators and education leaders imbued with ideals, aspirations, values and traditions of philippine life that can adapt to the challenges of the world.',
            'college_id' => '1',
        ]);

        Goal::create([
            'goal' => 'To provide world class professionals in the arts and sciences.',
            'college_id' => '2',
        ]);

        Goal::create([
            'goal' => 'To develop and maintain curricular programs that are relevant and responsive to regional and national development goals.',
            'college_id' => '2',
        ]);

        Goal::create([
            'goal' => 'To provide an academic perspective for the students to acquire the necessary tools for development within the managerial context.',
            'college_id' => '3',
        ]);
    }
}
